<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LuckyRewardRequest;
use App\Models\LuckyWheelReward;

class LuckyWheelController extends Controller
{
    public function store(LuckyRewardRequest $request)
    {
        return response()->json(LuckyWheelReward::create($request->validated()), 201);
    }

    public function update(LuckyRewardRequest $request, int $id)
    {
        $reward = LuckyWheelReward::findOrFail($id);
        $reward->update($request->validated());
        return response()->json($reward);
    }
}
