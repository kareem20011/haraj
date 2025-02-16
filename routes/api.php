<?php

use App\Http\Controllers\api\auth\AuthanticationController;
use App\Http\Controllers\api\auth\PasswordResetController;
use App\Http\Controllers\api\auth\ProfileController;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\MessageController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\SubcategoryController;
use Illuminate\Support\Facades\Route;


// authantication
Route::post('register', [AuthanticationController::class, 'register']);
Route::post('login', [AuthanticationController::class, 'login']);

// check token to get access
Route::middleware(['auth:sanctum'])->group(function () {
    // logout
    Route::post('logout', [AuthanticationController::class, 'logout']);

    // send reset password link via mail
    Route::post('forgot-password', [PasswordResetController::class, 'sendResetLink'])->name('password.email');
    Route::post('reset-password', [PasswordResetController::class, 'resetPassword'])->name('password.reset');

    // profile
    Route::get('profile', [ProfileController::class, 'show']);

    // Categories
    Route::get('categories/{lang}/index', [CategoryController::class, 'index']);
    Route::apiResource('categories', CategoryController::class)->except('index', 'update');
    Route::post('categories/update/{id}', [CategoryController::class, 'update']);
    
    // Subcategories
    Route::get('subcategories/{lang}/index', [SubcategoryController::class, 'index']);
    Route::apiResource('subcategories', SubcategoryController::class)->except('index', 'update');
    Route::post('subcategories/update/{id}', [SubcategoryController::class, 'update']);

    // Categories
    Route::apiResource('products', ProductController::class);
    
    // chat
    Route::post('/send-message', [MessageController::class, 'sendMessage']);
    Route::get('/messages/{userId}', [MessageController::class, 'getMessages']);
    Route::get('/old_chats', [MessageController::class, 'oldChats']);
});
