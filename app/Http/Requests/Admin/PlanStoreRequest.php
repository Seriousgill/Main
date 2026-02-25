<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PlanStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'gt:0'],
            'validity_days' => ['required', 'integer', 'gte:1'],
            'daily_task_income' => ['required', 'numeric', 'gte:0'],
            'referral_daily_income' => ['required', 'numeric', 'gte:0'],
            'referral_one_time_bonus' => ['required', 'numeric', 'gte:0'],
            'minimum_withdrawal' => ['required', 'numeric', 'gte:0'],
            'weekly_withdrawal_limit' => ['required', 'numeric', 'gte:0'],
            'status' => ['required', 'in:active,inactive'],
        ];
    }
}
