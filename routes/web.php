<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MenuController;

Route::get('/', function () {
    return view('index');
});

Route::prefix('administrator')->middleware('guest')->group(function (){

    Route::get('/login', [AuthController::class, 'showLogin']);
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
});