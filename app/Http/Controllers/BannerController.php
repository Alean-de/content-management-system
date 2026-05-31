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
        $banners = Banner::latest()->get();

       if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $banners
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

    public function showUpdate(Banner $banner)
    {
         return view(
            'administrator.updateBanner',
            compact('banner')
    );
    }

    public function updateBanner(Request $request, Banner $banner)
    {
         $request->validate([
            'title' => ['required'],
            'subtitle' => ['nullable'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'image' => ['nullable', 'image']
        ]);

        $imagePath = $banner->image;

        if ($request->hasFile('image')) {

            if ($banner->image) {
                Storage::disk('public')
                    ->delete($banner->image);
            }

            $imagePath = $request->file('image')
                ->store('banners', 'public');
        }

        $banner->update([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'image' => $imagePath,
            'is_active' => $request->has('is_active'),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date
        ]);

        return redirect()
            ->route('administrator.banner.')
            ->with('success', 'Banner berhasil diupdate');
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
