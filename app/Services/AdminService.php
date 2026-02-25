<?php

namespace App\Services;

use App\Models\Plan;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Withdrawal;

class AdminService
{
    public function dashboard(): array
    {
        return [
            'total_users' => User::where('role', 'user')->count(),
            'active_plans' => Plan::where('status', 'active')->count(),
            'deposits' => (float) Plan::sum('price'),
            'withdrawals' => (float) Withdrawal::where('status', 'approved')->sum('amount'),
            'pending_requests' => Withdrawal::where('status', 'pending')->count(),
            'profit_summary' => (float) Transaction::sum('amount'),
        ];
    }
}
