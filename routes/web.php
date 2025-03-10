<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\AdminMiddleware;

Route::middleware([
    'web',
    EnsureFrontendRequestsAreStateful::class,
])->group(function () {
    Route::get('/main', function () {
        return view('main');
    })->middleware('auth');
});

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'showloginpage'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/main', [ProductController::class, 'main'])->name('main');
    Route::post('/product', [ProductController::class, 'store'])->name('products.store');
    Route::get('/product/{article}', [ProductController::class, 'getProductByArticle']);
    Route::put('/product/{article}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/product/{article}', [ProductController::class, 'deleteProduct'])->name('products.delete');
});

Route::middleware([AdminMiddleware::class])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'showDashboard'])->name('dashboard');
    Route::get('/dashboard/users/{name}', [AdminController::class, 'getUser']);
    Route::delete('/dashboard/users/{name}', [AdminController::class, 'deleteUser']);
    Route::post('/dashboard/users', [AdminController::class, 'createUser']);
    Route::put('/dashboard/users/{name}', [AdminController::class, 'updateUser']);
});