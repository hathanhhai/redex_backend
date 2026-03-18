<?php

use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/products',ProductController::class.'@index');
Route::get('/product/{id}',ProductController::class.'@show');
Route::post('/product',ProductController::class.'@store');
Route::put('/product/{id}',ProductController::class.'@update');
Route::delete('/product/{id}',ProductController::class.'@destroy');
Route::get('/active-products',ProductController::class.'@activeProducts');

Route::post('/cart', [App\Http\Controllers\CartController::class, 'createCart']);
Route::get('/carts', [App\Http\Controllers\CartController::class, 'listCart']);
Route::put('/cart/{id}/status', [App\Http\Controllers\CartController::class, 'updateStatus']);
Route::delete('/cart/{id}', [App\Http\Controllers\CartController::class, 'destroy']);