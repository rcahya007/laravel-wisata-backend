<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.auth.login');
});

Route::middleware('auth')->group(
    function () {
        Route::get('/home', function () {
            return view('pages.dashboard', ['type_menu' => 'dashboard']);
        })->name('dashboard');
        Route::resource(
            'users',
            UserController::class,
        );
        Route::resource(
            'categories',
            CategoryController::class,
        );
        Route::resource('products', ProductController::class);
    }
);
