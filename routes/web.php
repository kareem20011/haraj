<?php

use App\Http\Controllers\web\LanguageController;
use App\Http\Controllers\web\auth\AuthanticationController;
use App\Http\Controllers\web\CategoryController;
use App\Http\Controllers\web\CommentController;
use App\Http\Controllers\web\HomeController;
use App\Http\Controllers\web\ProductController;
use App\Http\Controllers\web\ProductFavoriteController;
use App\Http\Controllers\web\ProfileController;
use App\Http\Controllers\web\SubcategoryController;
use Illuminate\Support\Facades\Route;

define('PAGINATE', 10);

// changing language
Route::get('lang', [LanguageController::class, 'index'])->name('lang');

// authantications
Route::group(['middleware' => 'guest'], function () {
    Route::get('register', [AuthanticationController::class, 'get_register'])->name('register');
    Route::post('register', [AuthanticationController::class, 'register'])->name('register');
    Route::get('login', [AuthanticationController::class, 'get_login'])->name('login');
    Route::post('login', [AuthanticationController::class, 'login'])->name('login');
});

route::middleware('auth')->group(function () {
    // logout
    Route::post('logout', [AuthanticationController::class, 'logout'])->name('logout');

    // profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    // products
    Route::get('products/{subcat}/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('products', [ProductController::class, 'store'])->name('products.store');
    Route::get('products/show/{product_id}', [ProductController::class, 'show'])->name('products.show');
    Route::get('products/edit/{product_id}', [ProductController::class, 'edit'])->name('products.edit');
    Route::post('products/update/{product_id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('products/{id}', [ProductController::class, 'delete'])->name('products.delete');

    // categories
    Route::get('categories/product-creation', [CategoryController::class, 'productCreation'])->name('categories.productCreation');
    Route::get('categories/show-products/{category_id}', [CategoryController::class, 'showProducts'])->name('categories.showProducts');
    Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('categories/store', [CategoryController::class, 'store'])->name('categories.store');

    // subcategories
    Route::get('subcategories/by-category/{category_id}', [SubcategoryController::class, 'getSubcategoriesByCategory'])->name('subcategories.getSubcategoriesByCategory');
    Route::get('subcategories/show-products/{subcategory_id}', [SubcategoryController::class, 'showProducts'])->name('subcategories.showProducts');
    Route::get('subcategories/create', [SubcategoryController::class, 'create'])->name('subcategories.create');
    Route::post('subcategories/store', [SubcategoryController::class, 'store'])->name('subcategories.store');

    // comments
    Route::post('products/{product}/comments', [CommentController::class, 'store'])->name('comments.store');

    // favorites
    Route::get('favorites', [ProductFavoriteController::class, 'index'])->name('favorites.index');
    Route::get('favorites/{product_id}', [ProductFavoriteController::class, 'store'])->name('favorites.store');
    Route::get('favorites/destory/{product_id}', [ProductFavoriteController::class, 'destory'])->name('favorites.destory');
});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('products/filter', [ProductController::class, 'filter'])->name('products.filter');
Route::get('products/search', [ProductController::class, 'search'])->name('products.search');
