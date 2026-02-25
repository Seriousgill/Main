<?php

namespace App\Console\Commands;

use App\Services\ReferralService;
use Illuminate\Console\Command;

class DistributeDailyReferralIncome extends Command
{
    protected $signature = 'mlm:daily-referral-income';
    protected $description = 'Credit daily referral income to eligible sponsors';

    public function handle(ReferralService $referralService): int
    {
        $count = $referralService->distributeDailyReferralIncome();
        $this->info("Distributed referral income to {$count} sponsors.");

        return self::SUCCESS;
    }
}
