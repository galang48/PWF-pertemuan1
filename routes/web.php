<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', [AboutController::class, 'index'])
    ->middleware('auth')
    ->name('about');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/product', [ProductController::class, 'index'])->name('product.index');
    Route::get('/product/export', [ProductController::class, 'export'])->name('product.export')->middleware('can:export-product');
    Route::post('/product', [ProductController::class, 'store'])->name('product.store');
    Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
    Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
    Route::put('/product/update/{id}', [ProductController::class, 'update'])->name('product.update');
    Route::get('/product/edit/{product}', [ProductController::class, 'edit'])->name('product.edit');
    Route::delete('/product/delete/{id}', [ProductController::class, 'delete'])->name('product.delete');

    Route::get('/category', [CategoryController::class, 'index'])->name('category.index')->middleware('can:manage-category');
    Route::post('/category', [CategoryController::class, 'store'])->name('category.store')->middleware('can:manage-category');
    Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create')->middleware('can:manage-category');
    Route::put('/category/update/{id}', [CategoryController::class, 'update'])->name('category.update')->middleware('can:manage-category');
    Route::get('/category/edit/{category}', [CategoryController::class, 'edit'])->name('category.edit')->middleware('can:manage-category');
    Route::delete('/category/delete/{id}', [CategoryController::class, 'delete'])->name('category.delete')->middleware('can:manage-category');
});

require __DIR__.'/auth.php';
