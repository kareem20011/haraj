<?php

use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\SubcategoryController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('admin.home');

    // categories
    Route::get('categories', [CategoryController::class, 'index'])->name('admin.categories.index');
    Route::get('categories/create', [CategoryController::class, 'create'])->name('admin.categories.create');
    Route::post('categories', [CategoryController::class, 'store'])->name('admin.categories.store');
    Route::get('categories/edit/{id}', [CategoryController::class, 'edit'])->name('admin.categories.edit');
    Route::post('categories/update/{id}', [CategoryController::class, 'update'])->name('admin.categories.update');
    Route::get('categories/delete/{id}', [CategoryController::class, 'delete'])->name('admin.categories.delete');

    // subcategories
    Route::get('subcategories', [SubcategoryController::class, 'index'])->name('admin.subcategories.index');
    Route::get('subcategories/create', [SubcategoryController::class, 'create'])->name('admin.subcategories.create');
    Route::post('subcategories', [SubcategoryController::class, 'store'])->name('admin.subcategories.store');
    Route::get('subcategories/edit/{id}', [SubcategoryController::class, 'edit'])->name('admin.subcategories.edit');
    Route::post('subcategories/update/{id}', [SubcategoryController::class, 'update'])->name('admin.subcategories.update');
    Route::get('subcategories/delete/{id}', [SubcategoryController::class, 'delete'])->name('admin.subcategories.delete');
});