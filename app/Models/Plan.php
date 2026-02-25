<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'validity_days',
        'daily_task_income',
        'referral_daily_income',
        'referral_one_time_bonus',
        'minimum_withdrawal',
        'weekly_withdrawal_limit',
        'status',
    ];

    public function userPlans(): HasMany
    {
        return $this->hasMany(UserPlan::class);
    }

    public function dailyTasks(): HasMany
    {
        return $this->hasMany(DailyTask::class);
    }
}
