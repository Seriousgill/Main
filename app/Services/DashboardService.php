<?php

namespace App\Services;

use App\Models\LuckySpin;
use App\Models\Transaction;
use App\Models\User;

class DashboardService
{
    public function userDashboard(User $user): array
    {
        $wallet = (new WalletService())->ensureWallet($user);

        return [
            'user' => $user->only(['id', 'name', 'email', 'mobile', 'referral_code']),
            'active_plan' => $user->activePlan()->with('plan')->first(),
            'wallet_balance' => (float) $wallet->balance,
            'today_income' => (float) Transaction::where('user_id', $user->id)->whereDate('created_at', today())->sum('amount'),
            'total_earnings' => (float) Transaction::where('user_id', $user->id)->where('amount', '>', 0)->sum('amount'),
            'lucky_spins_today' => LuckySpin::where('user_id', $user->id)->whereDate('created_at', today())->count(),
        ];
    }
}
