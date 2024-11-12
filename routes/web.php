<?php

use Illuminate\Support\Facades\Route;

Route::get('/signup', function () {
    return view('signup');
});
Route::get('/login', function () {
    return view('login');
});

// routes/web.php
use App\Http\Controllers\ProductController;

Route::get('/', [ProductController::class, 'index']);
Route::get('/products/create', [ProductController::class, 'create']);
Route::post('/products', [ProductController::class, 'store']);
Route::get('/products/{id}/edit', [ProductController::class, 'edit']);
Route::put('/products/{id}', [ProductController::class, 'update']);
Route::delete('/products/{id}', [ProductController::class, 'destroy']);
Route::get('/search', [ProductController::class, 'search']);

