<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Services\WalletService;

class WalletController extends Controller
{
    public function show(WalletService $walletService)
    {
        $user = auth('api')->user();

        return response()->json([
            'wallet' => $walletService->ensureWallet($user),
            'transactions' => Transaction::where('user_id', $user->id)->latest('id')->paginate(20),
        ]);
    }
}
