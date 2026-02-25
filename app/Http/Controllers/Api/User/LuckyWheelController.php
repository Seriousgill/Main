<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Services\LuckyWheelService;

class LuckyWheelController extends Controller
{
    public function __construct(private readonly LuckyWheelService $luckyWheelService)
    {
    }

    public function spin()
    {
        return response()->json($this->luckyWheelService->spin(auth('api')->user()), 201);
    }
}
