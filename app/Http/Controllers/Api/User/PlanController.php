<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\BuyPlanRequest;
use App\Services\PlanService;

class PlanController extends Controller
{
    public function __construct(private readonly PlanService $planService)
    {
    }

    public function index()
    {
        return response()->json($this->planService->getActivePlans());
    }

    public function buy(BuyPlanRequest $request)
    {
        $plan = $this->planService->purchasePlan(
            auth('api')->user(),
            (int) $request->validated('plan_id'),
            $request->validated('payment_reference')
        );

        return response()->json($plan, 201);
    }
}
