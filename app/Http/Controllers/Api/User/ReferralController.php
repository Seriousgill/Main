<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Services\ReferralService;

class ReferralController extends Controller
{
    public function __construct(private readonly ReferralService $referralService)
    {
    }

    public function index()
    {
        return response()->json($this->referralService->getUserReferrals(auth('api')->user()));
    }
}
