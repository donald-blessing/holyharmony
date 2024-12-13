<?php

declare(strict_types=1);

use App\Http\Controllers\Api\Profile\Api\Auth\GoogleLoginController;
use App\Http\Controllers\Api\Profile\ProfileController;
use App\Http\Controllers\Api\Profile\ProfileImageUpdateController;
use App\Http\Controllers\Api\Profile\ProfileUpdateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

require __DIR__ . '/auth.php';

Route::get('auth/google', [GoogleLoginController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [GoogleLoginController::class, 'handleGoogleCallback']);

Route::middleware(['auth:sanctum'])->group(function (): void {
    Route::prefix('profile')->group(function (): void {
        Route::get('/', ProfileController::class);
        Route::put('/update', ProfileUpdateController::class);
        Route::post('/image', ProfileImageUpdateController::class);
    });
});
