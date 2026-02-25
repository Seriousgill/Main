<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    public function register(array $data): array
    {
        if (!empty($data['referral_code'])) {
            $sponsor = User::where('referral_code', $data['referral_code'])->first();
            if (!$sponsor) {
                throw new \DomainException('Invalid referral code.');
            }
            $data['sponsor_id'] = $sponsor->id;
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'mobile' => $data['mobile'],
            'password' => Hash::make($data['password']),
            'referral_code' => strtoupper(Str::random(8)),
            'sponsor_id' => $data['sponsor_id'] ?? null,
            'role' => 'user',
            'status' => 'active',
        ]);

        (new WalletService())->ensureWallet($user);

        $token = JWTAuth::fromUser($user);

        return ['user' => $user, 'token' => $token];
    }

    public function login(array $credentials): array
    {
        $field = filter_var($credentials['identity'], FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile';
        $attempt = [$field => $credentials['identity'], 'password' => $credentials['password']];

        if (!$token = auth('api')->attempt($attempt)) {
            throw new \DomainException('Invalid login credentials.');
        }

        $user = auth('api')->user();

        if ($user->status !== 'active') {
            throw new \DomainException('Account blocked.');
        }

        return ['user' => $user, 'token' => $token];
    }
}
