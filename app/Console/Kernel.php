<?php

namespace App\Console;

use App\Console\Commands\DistributeDailyReferralIncome;
use App\Console\Commands\ExpireUserPlans;
use App\Console\Commands\ResetDailyTaskFlag;
use App\Console\Commands\WeeklyWithdrawalReset;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        DistributeDailyReferralIncome::class,
        ExpireUserPlans::class,
        ResetDailyTaskFlag::class,
        WeeklyWithdrawalReset::class,
    ];

    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('mlm:daily-task-reset')->dailyAt('00:05');
        $schedule->command('mlm:daily-referral-income')->dailyAt('00:15');
        $schedule->command('mlm:expire-plans')->hourly();
        $schedule->command('mlm:weekly-withdrawal-reset')->weeklyOn(1, '00:10');
    }
}
