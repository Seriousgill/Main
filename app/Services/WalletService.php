<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;

class WalletService
{
    public function ensureWallet(User $user): Wallet
    {
        return Wallet::firstOrCreate(['user_id' => $user->id], ['balance' => 0]);
    }

    public function credit(User $user, float $amount, string $type, string $description): Wallet
    {
        $wallet = $this->ensureWallet($user);
        $wallet->increment('balance', $amount);

        Transaction::create([
            'user_id' => $user->id,
            'type' => $type,
            'amount' => $amount,
            'description' => $description,
            'status' => 'success',
            'created_at' => now(),
        ]);

        return $wallet->fresh();
    }

    public function debit(User $user, float $amount, string $type, string $description): Wallet
    {
        $wallet = $this->ensureWallet($user);

        if ((float) $wallet->balance < $amount) {
            throw new \DomainException('Insufficient wallet balance.');
        }

        $wallet->decrement('balance', $amount);

        Transaction::create([
            'user_id' => $user->id,
            'type' => $type,
            'amount' => -1 * $amount,
            'description' => $description,
            'status' => 'success',
            'created_at' => now(),
        ]);

        return $wallet->fresh();
    }
}
