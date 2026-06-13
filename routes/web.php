<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\ProfileController;

Route::get('/', [PublicController::class, 'index'])->name('index');

Route::prefix('administrator')->middleware('guest')->group(function (){

    //  Login
    Route::get('/', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

    // Register
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register');

    // Forgot Password
    Route::get('/forgot_password', [AuthController::class, 'showForgot'])->name('forgotPass');
    Route::post('/forgot_password', [AuthController::class, 'change']);

}); 

Route::prefix('administrator')->middleware('auth')->name('administrator.')->group(function () {
    
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Menu Management
    Route::prefix('menu')->name('menu.')->group(function () {
        Route::get('/', [MenuController::class, 'index']);
        Route::post('/create/', [MenuController::class, 'store'])->name('store');
        Route::put('/update/{menuItem}', [MenuController::class, 'updateMenu'])->name('update');
        Route::delete('/delete/{menuItems}', [MenuController::class, 'delete'])->name('delete');
    });

    // Article Management
    Route::prefix('article')->name('article.')->group(function () {
        Route::get('/', [ArticleController::class, 'index']);
        Route::post('/create', [ArticleController::class, 'store'])->name('store');
        Route::put('/update/{article}', [ArticleController::class, 'updateArticle'])->name('update');
        Route::delete('/delete/{article}', [ArticleController::class, 'delete'])->name('delete');
    });

    // Banner Management
    Route::prefix('banner')->name('banner.')->group(function () {
        Route::get('/', [BannerController::class, 'index']);
        Route::post('/create', [BannerController::class, 'store'])->name('store');
        Route::put('/update/{banner}', [BannerController::class, 'updateBanner'])->name('update');
        Route::delete('/delete/{banner}', [BannerController::class, 'delete'])->name('delete');
    });

    // Gallery Management
    Route::prefix('gallery')->name('gallery.')->group(function () {
        Route::get('/', [GalleryController::class, 'index']);
        Route::post('/create', [GalleryController::class, 'store'])->name('store');
        Route::delete('/delete/{gallery}', [GalleryController::class, 'delete'])->name('delete');
    });

    // Message Management
    Route::prefix('message')->name('message.')->group(function () {
        Route::get('/', [MessagesController::class, 'index']);
        Route::post('/create', [MessagesController::class, 'store'])->name('store');
        Route::delete('/delete/{message}', [MessagesController::class, 'delete'])->name('delete');
    });

    // Profile Management
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index']);
        Route::put('/update/name', [ProfileController::class, 'updateName'])->name('name');
        Route::put('/update/pass', [ProfileController::class, 'updatePassword'])->name('password');
        Route::put('/update/email', [ProfileController::class, 'updateEmail'])->name('email');
    });
 
});


Route::prefix('public')->name('public.')->group(function () {
    
    Route::get('/about-us', [PublicController::class, 'aboutUs'])->name('aboutUs');
    
    Route::get('/beverage', [PublicController::class, 'drink'])->name('drink');
    
    Route::get('/food', [PublicController::class, 'food'])->name('food');
    
    Route::get('/article', [PublicController::class, 'article'])->name('article');
    
    Route::get('/article/{slug}', [PublicController::class, 'showArticle'])->name('article.show');
    
    Route::get('/gallery', [PublicController::class, 'gallery'])->name('gallery');
    
    Route::get('/contact', [PublicController::class, 'messageLoc'])->name('messageLoc');

});