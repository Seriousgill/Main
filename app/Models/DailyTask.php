<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DailyTask extends Model
{
    use HasFactory;

    protected $fillable = ['plan_id', 'title', 'description', 'reward_amount', 'status'];

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function completions(): HasMany
    {
        return $this->hasMany(TaskCompletion::class, 'task_id');
    }
}
