<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ResetDailyTaskFlag extends Command
{
    protected $signature = 'mlm:daily-task-reset';
    protected $description = 'Daily task reset placeholder for counters/cache';

    public function handle(): int
    {
        // Add cache/session cleanup if required.
        $this->info('Daily task reset executed.');

        return self::SUCCESS;
    }
}
