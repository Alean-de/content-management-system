<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller
{
    // 1. Menampilkan Data & Fitur Pencarian + Paginasi
    public function index(Request $request)
    {
        $search = $request->input('search');
        $category = $request->input('category');

        // Buat query dasar mengambil menu beserta relasi kategorinya (Eager Loading)
        $query = Menu::with('category')->latest();

        // Jika input pencarian tidak kosong, filter berdasarkan Nama atau Deskripsi
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')
                  ->orWhere('description', 'LIKE', '%' . $search . '%');
            });
        }

        if (!empty($category)) {
            $query->where('category_id', $category);
        }

        // Batasi data hanya 10 item per halaman
        $menuItems = $query->paginate(10);
        
        // Jika request datang dari AJAX (JavaScript), kembalikan data berformat JSON
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success'      => true,
                'data'         => $menuItems->items(),
                'current_page' => $menuItems->currentPage(),
                'last_page'    => $menuItems->lastPage(),
            ]);
        }

        // Jika halaman diakses langsung (bukan AJAX), tampilkan view blade asli
        $categories = Category::all();
        return view('administrator.menuAdm', compact('menuItems', 'categories'));
    }

    // 2. Menyimpan Data Menu Baru
    public function store(Request $request): JsonResponse
    {
        // Validasi inputan form
        $validator = Validator::make($request->all(), [
            'category_id' => ['required', 'exists:categories,id'],
            'name'        => ['required', 'string', 'max:255'],
            'price'       => ['required', 'numeric'],
            'description' => ['nullable', 'string'],
            'image'       => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048', 'dimensions:ratio=4/3'],
        ], [
            'image.dimensions' => 'Gunakan foto dengan aspek rasio 4:3',
            'image.max' => 'Ukuran maksimal 2MB',
            'image.mimes'      => 'Gagal! Format file wajib berupa JPEG, PNG, atau JPG.',
            'image.image'      => 'Gagal! File yang kamu unggah bukan berupa gambar.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ], 422);
        }

       
        $request->merge([
            'is_featured' => $request->has('is_featured') ? 1 : 0
        ]);

        $price = str_replace('.', '', $request->price);
        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('menu-items', 'public');
        }

        $menu = Menu::create([
            'category_id' => $request->category_id,
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $price,
            'image'       => $imagePath,
            'is_featured' => $request->is_featured // Ambil dari hasil merge di atas
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Menu berhasil ditambahkan',
            'data'    => $menu
        ], 200);
    }

    // 4. Memperbarui Data Menu
    public function updateMenu(Request $request, Menu $menuItem): JsonResponse
    {
        // Validasi input (image diatur nullable karena boleh tidak diganti)
        $validator = Validator::make($request->all(), [
            'category_id' => ['required', 'exists:categories,id'],
            'name'        => ['required', 'string', 'max:255'],
            'price'       => ['required'],
            'description' => ['nullable', 'string'],
            'image'       => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048', 'dimensions:ratio=4/3']
        ], [
            'image.dimensions' => 'Gunakan foto dengan aspek rasio 4:3',
            'image.max'        => 'Ukuran maksimal 2MB',
            'image.mimes'      => 'Gagal! Format file wajib berupa JPEG, PNG, atau JPG.',
            'image.image'      => 'Gagal! File yang kamu unggah bukan berupa gambar.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ], 422);
        }

        $price = str_replace('.', '', $request->price);
        $imagePath = $menuItem->image; // Default pakai path gambar lama

        // Jika user mengunggah gambar baru
        if ($request->hasFile('image')) {
            // Hapus berkas gambar lama dari storage agar berkas sampah tidak menumpuk
            if ($menuItem->image && Storage::disk('public')->exists($menuItem->image)) {
                Storage::disk('public')->delete($menuItem->image);
            }
            // Simpan gambar baru
            $imagePath = $request->file('image')->store('menu-items', 'public');
        }

        // Perbarui record di database
        $menuItem->update([
            'category_id' => $request->category_id,
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $price,
            'image'       => $imagePath,
            'is_featured' => $request->has('is_featured') ? 1 : 0
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Menu berhasil diperbarui!'
        ]);
    }

    // 5. Menghapus Data Menu
    public function delete(Menu $menuItems): JsonResponse
    {
        // Hapus fisik file gambar dari storage sebelum menghapus record database
        if ($menuItems->image && Storage::disk('public')->exists($menuItems->image)) {
            Storage::disk('public')->delete($menuItems->image);
        }

        // Hapus data dari database
        $menuItems->delete();

        return response()->json([
            'success' => true,
            'message' => 'Menu Berhasil Dihapus'
        ]);
    }
}