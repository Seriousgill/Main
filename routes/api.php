<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserDashboardController;
use App\Http\Controllers\Api\PlanController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\ReferralController;
use App\Http\Controllers\Api\LuckyWheelController;
use App\Http\Controllers\Api\WalletController;
use App\Http\Controllers\Api\WithdrawalController;
use App\Http\Controllers\Api\AdminController;

Route::prefix('auth')->group(function (): void {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('verify-otp', [AuthController::class, 'verifyOtp']);
    Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
});

Route::middleware(['auth:api'])->group(function (): void {
    Route::get('me', [UserDashboardController::class, 'profile']);
    Route::get('dashboard', [UserDashboardController::class, 'dashboard']);

    Route::prefix('plans')->group(function (): void {
        Route::get('', [PlanController::class, 'index']);
        Route::post('activate', [PlanController::class, 'activate']);
        Route::get('active', [PlanController::class, 'active']);
    });

    Route::prefix('tasks')->group(function (): void {
        Route::get('today', [TaskController::class, 'today']);
        Route::post('complete', [TaskController::class, 'complete']);
        Route::get('history', [TaskController::class, 'history']);
    });

    Route::prefix('referrals')->group(function (): void {
        Route::get('link', [ReferralController::class, 'link']);
        Route::get('list', [ReferralController::class, 'list']);
        Route::get('income', [ReferralController::class, 'income']);
    });

    Route::prefix('lucky-wheel')->group(function (): void {
        Route::get('rewards', [LuckyWheelController::class, 'rewards']);
        Route::get('eligibility', [LuckyWheelController::class, 'eligibility']);
        Route::post('spin', [LuckyWheelController::class, 'spin']);
        Route::get('history', [LuckyWheelController::class, 'history']);
    });

    Route::prefix('wallet')->group(function (): void {
        Route::get('summary', [WalletController::class, 'summary']);
        Route::get('transactions', [WalletController::class, 'transactions']);
    });

    Route::prefix('withdrawals')->group(function (): void {
        Route::get('eligibility', [WithdrawalController::class, 'eligibility']);
        Route::post('request', [WithdrawalController::class, 'request']);
        Route::get('history', [WithdrawalController::class, 'history']);
    });
});

Route::middleware(['auth:api', 'role:ADMIN'])->prefix('admin')->group(function (): void {
    Route::get('dashboard', [AdminController::class, 'dashboard']);

    Route::get('plans', [AdminController::class, 'plans']);
    Route::post('plans', [AdminController::class, 'storePlan']);
    Route::put('plans/{planId}', [AdminController::class, 'updatePlan']);
    Route::delete('plans/{planId}', [AdminController::class, 'deletePlan']);
    Route::post('plans/{planId}/toggle', [AdminController::class, 'togglePlanStatus']);

    Route::get('plan-tasks', [AdminController::class, 'planTasks']);
    Route::post('plan-tasks', [AdminController::class, 'storePlanTask']);
    Route::put('plan-tasks/{taskId}', [AdminController::class, 'updatePlanTask']);
    Route::delete('plan-tasks/{taskId}', [AdminController::class, 'deletePlanTask']);

    Route::get('users', [AdminController::class, 'users']);
    Route::post('users/{userUuid}/status', [AdminController::class, 'changeUserStatus']);
    Route::post('users/{userUuid}/upgrade', [AdminController::class, 'upgradePlan']);
    Route::post('users/{userUuid}/manual-credit', [AdminController::class, 'manualCredit']);
    Route::post('users/{userUuid}/manual-debit', [AdminController::class, 'manualDebit']);

    Route::get('withdrawals', [AdminController::class, 'withdrawals']);
    Route::post('withdrawals/{withdrawalUuid}/approve', [AdminController::class, 'approveWithdrawal']);
    Route::post('withdrawals/{withdrawalUuid}/reject', [AdminController::class, 'rejectWithdrawal']);

    Route::get('lucky-wheel/rewards', [AdminController::class, 'wheelRewards']);
    Route::post('lucky-wheel/rewards', [AdminController::class, 'storeWheelReward']);
    Route::put('lucky-wheel/rewards/{rewardId}', [AdminController::class, 'updateWheelReward']);
    Route::delete('lucky-wheel/rewards/{rewardId}', [AdminController::class, 'deleteWheelReward']);
    Route::post('lucky-wheel/toggle', [AdminController::class, 'toggleWheel']);

    Route::post('settings/platform', [AdminController::class, 'updatePlatformSettings']);
    Route::post('settings/income', [AdminController::class, 'updateIncomeSettings']);
    Route::post('settings/withdrawal', [AdminController::class, 'updateWithdrawalSettings']);
    Route::post('settings/security', [AdminController::class, 'updateSecuritySettings']);
});
