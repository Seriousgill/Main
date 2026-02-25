<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function (): void {
    Route::post('/auth/login', [\App\Http\Controllers\API\AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->group(function (): void {
        Route::post('/visitor/submit', [\App\Http\Controllers\API\VisitorApiController::class, 'store']);
        Route::post('/host/visits/{visit}/approve', [\App\Http\Controllers\API\HostApiController::class, 'approve']);
        Route::post('/host/visits/{visit}/decline', [\App\Http\Controllers\API\HostApiController::class, 'decline']);
        Route::post('/scan/entry', [\App\Http\Controllers\API\ScanController::class, 'entry']);
        Route::post('/scan/exit', [\App\Http\Controllers\API\ScanController::class, 'exit']);
    });
});
