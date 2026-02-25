<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserPlan;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\DB;

class WithdrawalService
{
    public function request(User $user, float $amount): Withdrawal
    {
        return DB::transaction(function () use ($user, $amount) {
            $activePlan = UserPlan::with('plan')
                ->where('user_id', $user->id)
                ->where('status', 'active')
                ->where('end_date', '>=', now())
                ->first();

            if (!$activePlan) {
                throw new \DomainException('Active plan required for withdrawal.');
            }

            if ($amount < (float) $activePlan->plan->minimum_withdrawal) {
                throw new \DomainException('Amount is below minimum withdrawal limit.');
            }

            $weeklyUsed = Withdrawal::where('user_id', $user->id)
                ->where('status', 'approved')
                ->whereBetween('requested_at', [now()->startOfWeek(), now()->endOfWeek()])
                ->sum('amount');

            if (($weeklyUsed + $amount) > (float) $activePlan->plan->weekly_withdrawal_limit) {
                throw new \DomainException('Weekly withdrawal limit exceeded.');
            }

            (new WalletService())->debit($user, $amount, 'withdrawal', 'Withdrawal requested');

            return Withdrawal::create([
                'user_id' => $user->id,
                'amount' => $amount,
                'fee' => 0,
                'status' => 'pending',
                'requested_at' => now(),
            ]);
        });
    }

    public function approve(Withdrawal $withdrawal): Withdrawal
    {
        $withdrawal->update(['status' => 'approved', 'processed_at' => now()]);
        return $withdrawal;
    }

    public function reject(Withdrawal $withdrawal): Withdrawal
    {
        return DB::transaction(function () use ($withdrawal) {
            if ($withdrawal->status !== 'pending') {
                throw new \DomainException('Only pending withdrawals can be rejected.');
            }

            $withdrawal->update(['status' => 'rejected', 'processed_at' => now()]);
            (new WalletService())->credit($withdrawal->user, (float) $withdrawal->amount, 'manual_credit', 'Withdrawal refund #' . $withdrawal->id);
            return $withdrawal;
        });
    }
}
