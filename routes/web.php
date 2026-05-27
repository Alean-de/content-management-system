<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;

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

Route::prefix('administrator')->middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('administrator.dashboard');

    Route::prefix('category')->group(function () {
        Route::get('/', [CategoryController::class, 'index']);
    }); 
});