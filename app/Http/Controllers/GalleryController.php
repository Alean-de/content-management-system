<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; 
use App\Models\Gallery;

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
        $request->validate([
            'title' => ['required'],
            'image' => ['required', 'image']
        ]);

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
