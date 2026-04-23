<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\QRCodeController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function (): void {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function (): void {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);
    });
});

Route::get('/events', [EventController::class, 'index']);
Route::get('/events/{event}', [EventController::class, 'show']);

Route::middleware('auth:sanctum')->group(function (): void {
    Route::post('/events', [EventController::class, 'store']);
    Route::post('/events/{event}/approve', [EventController::class, 'approve'])->middleware('role:admin');
    Route::post('/events/{event}/reject', [EventController::class, 'reject'])->middleware('role:admin');

    Route::post('/bookings', [BookingController::class, 'store']);
    Route::get('/bookings', [BookingController::class, 'index']);
    Route::post('/bookings/{booking}/cancel', [BookingController::class, 'cancel']);

    Route::post('/payments/razorpay/order', [PaymentController::class, 'createOrder']);
    Route::post('/payments/razorpay/verify', [PaymentController::class, 'verify']);

    Route::post('/qr/validate', [QRCodeController::class, 'validateCode'])->middleware('role:admin,organizer');
});
