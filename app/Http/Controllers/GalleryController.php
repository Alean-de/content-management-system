<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; 
use App\Models\Gallery;
use Illuminate\Support\Facades\Validator;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $galleries = Gallery::latest()->get();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $galleries
            ]);
        }

        return view('administrator.galleryAdm', compact('galleries'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048', 'dimensions:ratio=4/3']
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

        $imagePath = $request->file('image')->store('gallery', 'public');

        Gallery::create([
            'title' => $request->title,
            'image' => $imagePath
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Foto berhasil ditambahkan ke galeri!'
        ]);
    }

    public function delete(Gallery $gallery)
    {
        if ($gallery->image) {
            Storage::disk('public')->delete($gallery->image);
        }

        $gallery->delete();

       return response()->json([
            'success' => true,
            'message' => 'Foto berhasil dihapus dari galeri!'
        ]);
    }
}
