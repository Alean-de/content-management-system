<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return view('administrator.menuAdm', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => ['required', 'string', 'max:255', 'unique:categories']
        ]);

        Category::create([
            'category_name' => $request->category_name
        ]);
    }
}
