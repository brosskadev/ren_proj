<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', [ProductController::class, 'index']);

Route::post('/product', [ProductController::class, 'store'])->name('products.store');

Route::get('/product/{article}', [ProductController::class, 'getProductByArticle']);

Route::put('/product/{article}', [ProductController::class, 'update'])->name('products.update');

Route::delete('/product/{article}', [ProductController::class, 'deleteProduct'])->name('products.delete');