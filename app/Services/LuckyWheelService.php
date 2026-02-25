<?php

namespace App\Services;

use App\Models\LuckySpin;
use App\Models\LuckyWheelReward;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class LuckyWheelService
{
    public function spin(User $user): LuckySpin
    {
        return DB::transaction(function () use ($user) {
            $todaySpins = LuckySpin::where('user_id', $user->id)->whereDate('created_at', today())->count();
            $maxDailySpins = 3;

            if ($todaySpins >= $maxDailySpins) {
                throw new \DomainException('No spins left for today.');
            }

            $reward = $this->pickReward();
            if (!$reward) {
                throw new \DomainException('No active rewards configured.');
            }

            $spin = LuckySpin::create([
                'user_id' => $user->id,
                'reward_id' => $reward->id,
                'amount' => $reward->reward_amount,
                'created_at' => now(),
            ]);

            (new WalletService())->credit(
                $user,
                (float) $reward->reward_amount,
                'lucky_income',
                'Lucky wheel reward #' . $reward->id
            );

            return $spin->load('reward');
        });
    }

    protected function pickReward(): ?LuckyWheelReward
    {
        $rewards = LuckyWheelReward::where('status', 'active')->get();
        if ($rewards->isEmpty()) {
            return null;
        }

        $total = $rewards->sum('probability');
        $rand = mt_rand(1, (int) max(1, round($total * 10000)));
        $running = 0;

        foreach ($rewards as $reward) {
            $running += (int) round($reward->probability * 10000);
            if ($rand <= $running) {
                return $reward;
            }
        }

        return $rewards->last();
    }
}
