<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class LuckyRewardRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'reward_amount' => ['required', 'numeric', 'gte:0'],
            'probability' => ['required', 'numeric', 'gt:0'],
            'status' => ['required', 'in:active,inactive'],
        ];
    }
}
