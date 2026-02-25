<?php

use App\Http\Controllers\Api\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Api\Admin\LuckyWheelController as AdminLuckyWheelController;
use App\Http\Controllers\Api\Admin\PlanController as AdminPlanController;
use App\Http\Controllers\Api\Admin\SystemSettingsController;
use App\Http\Controllers\Api\Admin\UserController as AdminUserController;
use App\Http\Controllers\Api\Admin\WithdrawalController as AdminWithdrawalController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\User\DashboardController;
use App\Http\Controllers\Api\User\LuckyWheelController;
use App\Http\Controllers\Api\User\PlanController;
use App\Http\Controllers\Api\User\ReferralController;
use App\Http\Controllers\Api\User\TaskController;
use App\Http\Controllers\Api\User\WalletController;
use App\Http\Controllers\Api\User\WithdrawalController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');

Route::middleware(['auth:api', 'role:user'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/plans', [PlanController::class, 'index']);
    Route::post('/buy-plan', [PlanController::class, 'buy']);
    Route::post('/complete-task', [TaskController::class, 'complete']);
    Route::get('/referrals', [ReferralController::class, 'index']);
    Route::post('/spin-wheel', [LuckyWheelController::class, 'spin']);
    Route::get('/wallet', [WalletController::class, 'show']);
    Route::post('/withdraw', [WithdrawalController::class, 'request']);
});

Route::prefix('admin')->middleware(['auth:api', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index']);
    Route::post('/plan', [AdminPlanController::class, 'store']);
    Route::put('/plan/{id}', [AdminPlanController::class, 'update']);
    Route::delete('/plan/{id}', [AdminPlanController::class, 'destroy']);
    Route::post('/users/{id}/toggle-status', [AdminUserController::class, 'toggleStatus']);
    Route::post('/users/{id}/manual-balance', [AdminUserController::class, 'manualBalanceUpdate']);
    Route::post('/withdrawal/{id}/approve', [AdminWithdrawalController::class, 'approve']);
    Route::post('/withdrawal/{id}/reject', [AdminWithdrawalController::class, 'reject']);
    Route::post('/lucky-wheel/reward', [AdminLuckyWheelController::class, 'store']);
    Route::put('/lucky-wheel/reward/{id}', [AdminLuckyWheelController::class, 'update']);
    Route::post('/settings', [SystemSettingsController::class, 'update']);
});
