<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ManualCreditRequest;
use App\Models\User;
use App\Services\WalletService;

class UserController extends Controller
{
    public function toggleStatus(int $id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => $user->status === 'active' ? 'blocked' : 'active']);

        return response()->json($user);
    }

    public function manualBalanceUpdate(ManualCreditRequest $request, int $id, WalletService $walletService)
    {
        $user = User::findOrFail($id);
        $data = $request->validated();

        if ($data['type'] === 'manual_credit') {
            $wallet = $walletService->credit($user, (float) $data['amount'], 'manual_credit', $data['description']);
        } else {
            $wallet = $walletService->debit($user, (float) $data['amount'], 'manual_debit', $data['description']);
        }

        return response()->json($wallet);
    }
}
