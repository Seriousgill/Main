<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LuckySpin extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['user_id', 'reward_id', 'amount', 'created_at'];

    protected $casts = ['amount' => 'decimal:2'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reward(): BelongsTo
    {
        return $this->belongsTo(LuckyWheelReward::class, 'reward_id');
    }
}
