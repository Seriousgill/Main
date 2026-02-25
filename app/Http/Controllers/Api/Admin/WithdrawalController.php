<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use App\Services\WithdrawalService;

class WithdrawalController extends Controller
{
    public function approve(int $id, WithdrawalService $withdrawalService)
    {
        $withdrawal = Withdrawal::findOrFail($id);
        return response()->json($withdrawalService->approve($withdrawal));
    }

    public function reject(int $id, WithdrawalService $withdrawalService)
    {
        $withdrawal = Withdrawal::findOrFail($id);
        return response()->json($withdrawalService->reject($withdrawal));
    }
}
