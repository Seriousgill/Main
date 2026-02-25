<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LuckyWheelReward extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['reward_amount', 'probability', 'status'];

    protected $casts = [
        'reward_amount' => 'decimal:2',
        'probability' => 'decimal:2',
    ];
}
