<?php

declare(strict_types=1);

use App\Http\Controllers\Api\Auth\GoogleLoginController;
use App\Http\Controllers\Api\Profile\ProfileController;
use App\Http\Controllers\Api\Profile\ProfileImageUpdateController;
use App\Http\Controllers\Api\Profile\ProfileUpdateController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostDownloadController;
use App\Http\Controllers\PostsTrendsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

require __DIR__.'/auth.php';

Route::get('auth/google', [GoogleLoginController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [GoogleLoginController::class, 'handleGoogleCallback']);

Route::middleware(['auth:sanctum'])->group(function (): void {
    Route::prefix('profile')->group(function (): void {
        Route::get('/', ProfileController::class);
        Route::put('/update', ProfileUpdateController::class);
        Route::post('/image', ProfileImageUpdateController::class);
    });

    Route::get('posts/trends', PostsTrendsController::class);
    Route::get('posts/download', PostDownloadController::class);
    Route::get('posts/{category}/category', [CategoriesController::class, 'show']);
    Route::get('posts/categories', CategoriesController::class);
    Route::apiResource('posts', PostController::class);
});
