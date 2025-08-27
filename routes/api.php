<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\Auth\InviteController;
use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\Auth\MagicLinkController;
use App\Http\Controllers\Api\V1\Auth\OtpController;
use App\Http\Controllers\Api\V1\ProfileController;
use App\Http\Controllers\Api\V1\WellnessController;

Route::get('test', function () {
    return response()->json(['message' => 'API is working']);
});

Route::prefix('v1')->name('v1.')->group(function () {


    Route::prefix('admin')->name('admin.')
        ->middleware(['admin.api', 'throttle:5,1'])
        ->group(function () {
            Route::post('/invite', [InviteController::class, 'store']);
        });


    // Flow 1: Magic Link
    Route::get('/magic-link/user', [LoginController::class, 'loginWithToken'])
        ->middleware('throttle:10,1')->name('magic-login');

    Route::get('/verify-email', [OtpController::class, 'verifyEmail'])
        ->middleware('throttle:20,1');
    Route::post('/send-otp', [OtpController::class, 'sendOtp'])
        ->middleware('throttle:5,1');
    Route::post('/verify-otp', [OtpController::class, 'verifyOtp'])
        ->middleware('throttle:10,1');


    // Profile
    Route::middleware('auth:sanctum')->group(function () {
        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('/', [ProfileController::class, 'index'])->name('index');
            Route::post('', [ProfileController::class, 'update'])->name('update');
        });

        Route::prefix('wellness')->name('wellness.')->group(function () {

            Route::prefix('interests')->group(function () {
                Route::get('/', [WellnessController::class, 'getInterests'])->name('index');
                Route::post('', [WellnessController::class, 'storeInterests'])->name('update');
            });

            Route::prefix('pillars')->group(function () {
                Route::get('/', [WellnessController::class, 'getPillars'])->name('index');
                Route::post('', [WellnessController::class, 'storePillars'])->name('update');
            });
        });
    });
});
