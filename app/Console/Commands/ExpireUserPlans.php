<?php

namespace App\Console\Commands;

use App\Models\UserPlan;
use Illuminate\Console\Command;

class ExpireUserPlans extends Command
{
    protected $signature = 'mlm:expire-plans';
    protected $description = 'Expire plans that passed end date';

    public function handle(): int
    {
        $updated = UserPlan::where('status', 'active')->where('end_date', '<', now())->update(['status' => 'expired']);
        $this->info("Expired {$updated} user plans.");

        return self::SUCCESS;
    }
}
