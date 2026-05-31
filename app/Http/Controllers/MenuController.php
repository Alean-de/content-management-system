<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Category;
use Illuminate\Support\Facades\Storage; 

class MenuController extends Controller
{
    public function index()
    {
        $menuItems = Menu::with('category')
            ->latest()
            ->get();
        
        $categories = Category::all();

        return view(
            'administrator.menuAdm',
            compact('menuItems', 'categories')
        );
    }
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric'],
            'description' => ['nullable', 'string'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048']
        ]);

        $price = str_replace('.', '', $request->price);

        $imagePath = null;

        if ($request->hasFile('image')) {

            $imagePath = $request->file('image')
                ->store('menu-items', 'public');
        }

            $menu = Menu::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $price,
            'image' => $imagePath,
            'is_featured' => $request->has('is_featured')
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Menu berhasil ditambahkan',
            'data' => $menu
        ]);
    }

    public function showUpdate(Menu $menuItem)
    {
        $categories = Category::all();

        return view('administrator.updateMenu', compact('menuItem', 'categories'));
    }

    public function updateMenu(Request $request, Menu $menuItem)
    {
        $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048']
        ]);

        $price = str_replace('.', '', $request->price);

        $imagePath = $menuItem->image;

        if ($request->hasFile('image')) {

        if ($menuItem->image) {

            Storage::disk('public')
                ->delete($menuItem->image);
        }

        $imagePath = $request->file('image')
            ->store('menu-items', 'public');
    }

        $menuItem->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $price,
            'image' => $imagePath,
            'is_featured' => $request->has('is_featured')
        ]);

        return redirect()
            ->route('administrator.menu.')
            ->with('success', 'Menu berhasil diupdate');
    }

    public function delete(Menu $menuItem)
    {
        if ($menuItem->image) {

        Storage::disk('public')
            ->delete($menuItem->image);
        }

        $menuItem->delete();

        return back()->with(
            'success',
            'Menu Berhasil Disimpan'
        );
    }

    public function jsonMenu()
    {
        return response()->json([
            'success' => true,
            'data' => Menu::all()
        ]);
    }
}
