<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PlanStoreRequest;
use App\Models\Plan;

class PlanController extends Controller
{
    public function store(PlanStoreRequest $request)
    {
        return response()->json(Plan::create($request->validated()), 201);
    }

    public function update(PlanStoreRequest $request, int $id)
    {
        $plan = Plan::findOrFail($id);
        $plan->update($request->validated());
        return response()->json($plan);
    }

    public function destroy(int $id)
    {
        Plan::findOrFail($id)->delete();
        return response()->json(['message' => 'Plan deleted']);
    }
}
