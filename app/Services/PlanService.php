<?php

namespace App\Services;

use App\Models\Plan;
use App\Models\Referral;
use App\Models\User;
use App\Models\UserPlan;
use Illuminate\Support\Facades\DB;

class PlanService
{
    public function getActivePlans()
    {
        return Plan::where('status', 'active')->orderBy('price')->get();
    }

    public function purchasePlan(User $user, int $planId, string $paymentReference): UserPlan
    {
        return DB::transaction(function () use ($user, $planId, $paymentReference) {
            $plan = Plan::where('id', $planId)->where('status', 'active')->firstOrFail();
            $this->verifyPayment($paymentReference, $plan->price);

            UserPlan::where('user_id', $user->id)->where('status', 'active')->update(['status' => 'expired']);

            $userPlan = UserPlan::create([
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'start_date' => now(),
                'end_date' => now()->addDays($plan->validity_days),
                'status' => 'active',
            ]);

            if ($user->sponsor_id && $user->sponsor_id !== $user->id) {
                $referral = Referral::firstOrCreate(
                    [
                        'sponsor_id' => $user->sponsor_id,
                        'referred_user_id' => $user->id,
                        'plan_id' => $plan->id,
                    ],
                    ['one_time_bonus_paid' => false, 'created_at' => now()]
                );

                if (!$referral->one_time_bonus_paid) {
                    $sponsor = User::findOrFail($user->sponsor_id);
                    (new WalletService())->credit(
                        $sponsor,
                        (float) $plan->referral_one_time_bonus,
                        'referral_income',
                        'One-time referral bonus from user #' . $user->id
                    );
                    $referral->update(['one_time_bonus_paid' => true]);
                }
            }

            return $userPlan->load('plan');
        });
    }

    protected function verifyPayment(string $paymentReference, float $expectedAmount): void
    {
        if (trim($paymentReference) === '') {
            throw new \DomainException('Payment reference is required.');
        }

        // Replace with real provider verification callback integration.
        if (strlen($paymentReference) < 8) {
            throw new \DomainException('Payment verification failed.');
        }
    }
}
