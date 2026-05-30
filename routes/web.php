<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\MessagesController;

Route::get('/', function () {
    return view('index');
});

Route::prefix('administrator')->middleware('guest')->group(function (){

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

    Route::get('/register', [AuthController::class, 'showRegister']);
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/forgot_password', [AuthController::class, 'showForgot']);
    Route::post('/forgot_password', [AuthController::class, 'change']);

}); 

Route::prefix('administrator')->middleware('auth')->name('administrator.')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    Route::prefix('menu')->name('menu.')->group(function () {
        Route::get('/', [MenuController::class, 'index']);
        Route::get('/update/{menuItem}', [MenuController::class, 'showUpdate'])->name('showUpdate');
        Route::post('/create', [MenuController::class, 'store'])->name('store');
        Route::put('/update/{menuItem}', [MenuController::class, 'updateMenu'])->name('update');
        Route::delete('/delete/{menuItem}', [MenuController::class, 'delete'])->name('delete');
    }); 

    Route::prefix('article')->name('article.')->group(function () {
        Route::get('/', [ArticleController::class, 'index']);
        Route::get('/update/{article}', [ArticleController::class, 'showUpdate'])->name('showUpdate');
        Route::post('/create', [ArticleController::class, 'store'])->name('store');
        Route::put('/update/{article}', [ArticleController::class, 'updateArticle'])->name('update');
        Route::delete('/delete/{article}', [ArticleController::class, 'delete'])->name('delete');
    });

    Route::prefix('banner')->name('banner.')->group(function () {
        Route::get('/', [BannerController::class, 'index']);
        Route::get('/update/{banner}', [BannerController::class, 'showUpdate'])->name('showUpdate');
        Route::post('/create', [BannerController::class, 'store'])->name('store');
        Route::put('/update/{banner}', [BannerController::class, 'updateBanner'])->name('update');
        Route::delete('/delete/{banner}', [BannerController::class, 'delete'])->name('delete');
    });

    Route::prefix('gallery')->name('gallery.')->group(function () {
        Route::get('/', [GalleryController::class, 'index']);
        Route::post('/create', [GalleryController::class, 'store'])->name('store');
        Route::delete('/delete/{gallery}', [GalleryController::class, 'delete'])->name('delete');
    });

    Route::prefix('message')->name('message.')->group(function () {
        Route::get('/', [MessagesController::class, 'index']);
        Route::get('/show/{message}', [MessagesController::class, 'show'])->name('show');
        Route::delete('/delete/{message}', [MessagesController::class, 'delete'])->name('delete');
    });

});