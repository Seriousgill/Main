<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'host'])->prefix('host')->name('host.')->group(function (): void {
    Route::get('/dashboard', [\App\Http\Controllers\Host\DashboardController::class, 'index'])->name('dashboard');
    Route::post('/approvals/{visit}/approve', [\App\Http\Controllers\Host\ApprovalController::class, 'approve'])->name('approvals.approve');
    Route::post('/approvals/{visit}/decline', [\App\Http\Controllers\Host\ApprovalController::class, 'decline'])->name('approvals.decline');
    Route::resource('visitors', \App\Http\Controllers\Host\VisitorController::class)->only(['index', 'show']);
});
