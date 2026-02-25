<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Services\TaskService;

class TaskController extends Controller
{
    public function __construct(private readonly TaskService $taskService)
    {
    }

    public function complete()
    {
        $completion = $this->taskService->completeTodayTask(auth('api')->user());
        return response()->json($completion, 201);
    }
}
