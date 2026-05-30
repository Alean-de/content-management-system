<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; 
use App\Models\Article;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('user')
            ->latest()
            ->get();
 
        return view(
            'administrator.articleAdm',
            compact('articles')
        );
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

            $thumbnailPath = $request->file('thumbnail')
                ->store('articles', 'public');

        }

        Article::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'thumbnail' =>  $thumbnailPath,
            'published_at' => now()
        ]);

        return back()->with(
            'success',
            'Article berhasil ditambahkan'
        );
    }

    public function showUpdate(Article $article)
    {
        return view('administrator.updateArticle', compact('article'));
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

            Storage::disk('public')
                ->delete($article->thumbnail);

        }

        $article->delete();

        return back()->with(
            'success',
            'Article berhasil dihapus'
        );
    }
}
