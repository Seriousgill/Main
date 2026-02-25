<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SystemSettingsController extends Controller
{
    public function update(Request $request)
    {
        $data = $request->validate([
            'referral_system_enabled' => ['required', 'boolean'],
            'task_system_enabled' => ['required', 'boolean'],
            'lucky_wheel_enabled' => ['required', 'boolean'],
            'maintenance_mode' => ['required', 'boolean'],
            'withdrawal_fee_percent' => ['required', 'numeric', 'min:0'],
        ]);

        // Persist to settings store or dedicated table in implementation phase.
        return response()->json(['settings' => $data]);
    }
}
