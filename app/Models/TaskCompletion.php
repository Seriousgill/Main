<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskCompletion extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['user_id', 'task_id', 'completed_date', 'income_credited', 'created_at'];

    protected $casts = [
        'completed_date' => 'date',
        'income_credited' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(DailyTask::class, 'task_id');
    }
}
