<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class BuyPlanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'plan_id' => ['required', 'integer', 'exists:plans,id'],
            'payment_reference' => ['required', 'string', 'min:8'],
        ];
    }
}
