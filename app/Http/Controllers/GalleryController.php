<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; 
use App\Models\Gallery;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::latest()->get();

        return view(
            'administrator.galleryAdm',
            compact('galleries')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required'],
            'image' => ['required', 'image']
        ]);

        $imagePath = $request->file('image')
            ->store('gallery', 'public');

        Gallery::create([
            'title' => $request->title,
            'image' => $imagePath
        ]);

        return back()->with(
            'success',
            'Foto berhasil ditambahkan'
        );
    }

    public function delete(Gallery $gallery)
    {
        if ($gallery->image) {
            Storage::disk('public')
                ->delete($gallery->image);
        }

        $gallery->delete();

        return back()->with(
            'success',
            'Foto berhasil dihapus'
        );
    }
}
