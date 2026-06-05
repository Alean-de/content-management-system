<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage; 
use App\Models\Banner;

class BannerController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $query = Banner::latest();

        if (!empty($search)) {
            $query->where('title', 'LIKE', '%' . $search . '%');
        }

        if ($status !== null && $status !== '') {
            $query->where('is_active', $status);
        }

        // Batasi data hanya 10 item per halaman
        $banners = $query->paginate(10);

        // FIX UTAMA: Paksa format start_date dan end_date murni YYYY-MM-DD agar dimengerti HTML input date
        $banners->through(function ($banner) {
            $banner->start_date = $banner->start_date ? \Carbon\Carbon::parse($banner->start_date)->format('Y-m-d') : null;
            $banner->end_date = $banner->end_date ? \Carbon\Carbon::parse($banner->end_date)->format('Y-m-d') : null;
            return $banner;
        });
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success'      => true,
                'data'         => $banners->items(),
                'current_page' => $banners->currentPage(),
                'last_page'    => $banners->lastPage(),
            ]);
        }

        return view('administrator.bannerAdmn', compact('banners'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'subtitle' => 'nullable|max:255',
            'image' => 'required|image',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('banners', 'public');
        }

        Banner::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'image' => $imagePath,
            'is_active' => $request->has('is_active'),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Banner berhasil ditambahkan!'
        ]);
    }

    public function updateBanner(Request $request, Banner $banner)
    {
        // 1. Validasi input form banner
        $request->validate([
            'title'      => ['required', 'string', 'max:255'],
            'subtitle'   => ['nullable', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date'   => ['required', 'date'],
            'image'      => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048']
        ]);

        $imagePath = $banner->image; // Default pakai gambar banner yang lama

        // Jika admin mengunggah file spanduk baru
        if ($request->hasFile('image')) {
            // Hapus gambar banner lama dari storage agar tidak memenuhi server
            if ($banner->image && Storage::disk('public')->exists($banner->image)) {
                Storage::disk('public')->delete($banner->image);
            }
            // Simpan file banner baru
            $imagePath = $request->file('image')->store('banners', 'public');
        }

        // 2. Perbarui record ke database (FIX: start_date & end_date kita salurkan ke sini)
        $banner->update([
            'title'       => $request->title,
            'subtitle'    => $request->subtitle,
            'image'       => $imagePath,
            'start_date'  => $request->start_date, // FIX: Tanggal mulai disimpan
            'end_date'    => $request->end_date,   // FIX: Tanggal selesai disimpan
            'is_active'   => $request->has('is_active') ? 1 : 0
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Banner berhasil diperbarui!'
        ]);
    }

    public function delete(Banner $banner)
    {
        if ($banner->image) {
            Storage::disk('public')->delete($banner->image);
        }

        $banner->delete();

        return response()->json([
            'success' => true,
            'message' => 'Banner berhasil dihapus!'
        ]);
    }

}
