<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\WithdrawalRequest;
use App\Services\WithdrawalService;

class WithdrawalController extends Controller
{
    public function request(WithdrawalRequest $request, WithdrawalService $withdrawalService)
    {
        $withdrawal = $withdrawalService->request(auth('api')->user(), (float) $request->validated('amount'));
        return response()->json($withdrawal, 201);
    }
}
