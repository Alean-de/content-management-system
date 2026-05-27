<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::latest()->get();

        return view('administrator.categoriesAdm', compact('category'));
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
