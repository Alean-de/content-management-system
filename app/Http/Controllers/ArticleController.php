<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; 
use App\Models\Article;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    // 1. Menampilkan Data Artikel & Fitur Pencarian + Paginasi
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Buat query dasar mengambil artikel beserta relasi user/pembuatnya (Eager Loading)
        $query = Article::with('user')->latest();

        // Jika ada input pencarian dari JavaScript, saring berdasarkan judul (title)
        if (!empty($search)) {
            $query->where('title', 'LIKE', '%' . $search . '%');
        }

        // Batasi data hanya 10 item per halaman (mengubah ->get() menjadi ->paginate())
        $articles = $query->paginate(10);
        
        // Jika request datang dari AJAX (JavaScript), kembalikan data berformat JSON lengkap dengan metadata paginasi
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success'      => true,
                'data'         => $articles->items(),       // Hanya memuntahkan array datanya
                'current_page' => $articles->currentPage(), // Mengirim halaman aktif saat ini (Fix NaN)
                'last_page'    => $articles->lastPage(),    // Mengirim total halaman terakhir
            ]);
        }

        // Jika halaman diakses langsung lewat browser (bukan AJAX)
        return view('administrator.articleAdm', compact('articles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required'],
            'thumbnail' => ['nullable', 'image']
        ]);

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('articles', 'public');
        }

        Article::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'thumbnail' =>  $thumbnailPath,
            'published_at' => now()
        ]);

       return response()->json([
            'success' => true,
            'message' => 'Article berhasil ditambahkan!'
        ]);
    }

    public function updateArticle(Request $request, Article $article)
    {
         $request->validate([
        'title' => ['required'],
        'content' => ['required']
        ]);

        $thumbnailPath = $article->thumbnail;

        if ($request->hasFile('thumbnail')) {

            if ($article->thumbnail) {

                Storage::disk('public')
                    ->delete($article->thumbnail);
            }

            $thumbnailPath = $request->file('thumbnail')
                ->store('articles', 'public');
        }

        $article->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'thumbnail' => $thumbnailPath
        ]);

        return redirect()
            ->route('administrator.article.')
            ->with('success', 'Article berhasil diupdate');

    }

    public function delete(Article $article)
    {
        if ($article->thumbnail) {
            Storage::disk('public')->delete($article->thumbnail);
        }

        $article->delete();

        return response()->json([
            'success' => true,
            'message' => 'Article berhasil dihapus tanpa sisa!'
        ]);
    }

}
