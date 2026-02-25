<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class WeeklyWithdrawalReset extends Command
{
    protected $signature = 'mlm:weekly-withdrawal-reset';
    protected $description = 'Weekly withdrawal reset hook';

    public function handle(): int
    {
        // Weekly counters are computed by date range in service; hook retained for extensibility.
        $this->info('Weekly withdrawal reset hook executed.');

        return self::SUCCESS;
    }
}
