<?php

namespace App\Services;

use App\Models\Referral;
use App\Models\User;
use App\Models\UserPlan;
use Illuminate\Support\Facades\DB;

class ReferralService
{
    public function getUserReferrals(User $user)
    {
        return Referral::with(['referredUser:id,name,email,mobile', 'plan:id,name,referral_daily_income'])
            ->where('sponsor_id', $user->id)
            ->orderByDesc('created_at')
            ->get();
    }

    public function distributeDailyReferralIncome(): int
    {
        $count = 0;
        DB::transaction(function () use (&$count) {
            $activePlans = UserPlan::with(['user', 'plan'])
                ->where('status', 'active')
                ->where('end_date', '>=', now())
                ->get();

            foreach ($activePlans as $referredPlan) {
                $referral = Referral::where('referred_user_id', $referredPlan->user_id)
                    ->where('plan_id', $referredPlan->plan_id)
                    ->first();

                if (!$referral) {
                    continue;
                }

                $sponsorActivePlan = UserPlan::where('user_id', $referral->sponsor_id)
                    ->where('status', 'active')
                    ->where('end_date', '>=', now())
                    ->exists();

                if (!$sponsorActivePlan) {
                    continue;
                }

                $description = 'Daily referral income from user #' . $referredPlan->user_id . ' [' . now()->toDateString() . ']';
                $alreadyCredited = \App\Models\Transaction::where('user_id', $referral->sponsor_id)
                    ->where('type', 'referral_income')
                    ->where('description', $description)
                    ->exists();

                if ($alreadyCredited) {
                    continue;
                }

                (new WalletService())->credit(
                    User::findOrFail($referral->sponsor_id),
                    (float) $referredPlan->plan->referral_daily_income,
                    'referral_income',
                    $description
                );

                $count++;
            }
        });

        return $count;
    }
}
