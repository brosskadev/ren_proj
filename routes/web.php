<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', [ProductController::class, 'index']);

Route::post('/products', [ProductController::class, 'store'])->name('products.store');

Route::get('/product/{article}', [ProductController::class, 'getProductByArticle']);

Route::delete('/product/{article}', [ProductController::class, 'deleteProduct'])->name('products.delete');