<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Gallery;
use App\Models\Article;
use App\Models\Banner;

class PublicController extends Controller
{
    public function index()
    {
        $featuredMenus = Menu::where('is_featured', 1)->latest()->take(3)->get();

        $banners = Banner::where('is_active', 1)->latest()->take(5)->get();

        return view('index', compact('featuredMenus', 'banners'));
    }

    public function aboutUs()
    {
        return view('aboutUs');
    }

    public function drink()
    {
        // Ambil data minuman berdasarkan nama kategori relasinya di DB
        $coffeeMenus = Menu::whereHas('category', function($query) {
            $query->where('name', 'like', '%coffee%')->where('name', 'not like', '%non%');
        })->latest()->get();

        $nonCoffeeMenus = Menu::whereHas('category', function($query) {
            $query->where('name', 'like', '%non-coffee%');
        })->latest()->get();

        // Lempar dua variabel bersih ini ke view
        return view('menuMinuman', compact('coffeeMenus', 'nonCoffeeMenus'));
    }

    public function food()
    {
        // Mengambil semua menu yang tergolong makanan untuk di-looping di Blade
        $mainCourse = Menu::whereHas('category', function($query) {
            $query->where('name', 'like', '%main%')->where('name', 'not like', '%bake%');
        })->latest()->get();

        $bakery = Menu::whereHas('category', function($query) {
            $query->where('name', 'like', '%light bites%');
        })->latest()->get();

        return view('menuMakanan', compact('mainCourse', 'bakery'));
    }

    public function article()
    {
        // 1. Ambil semua data artikel dari database, urutkan dari yang paling gres/terbaru
        $articles = Article::latest()->get();

        // 2. Lempar variabel $articles ke dalam file view 'article'
        return view('article', compact('articles'));
    }

    public function showArticle($slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();

        return view('articleDetail', compact('article'))->with('title', 'Article');
    }

    public function gallery()
    {
        // 1. Ambil semua data foto galeri dari database
        // Bisa pakai latest() biar foto yang baru di-upload admin muncul duluan
        $galleries = Gallery::latest()->get();

        // 2. Lempar data variabel $galleries ke file view 'gallery'
        return view('gallery', compact('galleries'));
    }

    public function messageLoc()
    {
        return view('message');
    }
}
