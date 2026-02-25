<?php

namespace App\Services;

use App\Models\DailyTask;
use App\Models\TaskCompletion;
use App\Models\User;
use App\Models\UserPlan;
use Illuminate\Support\Facades\DB;

class TaskService
{
    public function completeTodayTask(User $user): TaskCompletion
    {
        return DB::transaction(function () use ($user) {
            $activePlan = UserPlan::with('plan')
                ->where('user_id', $user->id)
                ->where('status', 'active')
                ->where('end_date', '>=', now())
                ->first();

            if (!$activePlan) {
                throw new \DomainException('Active plan required for daily task.');
            }

            $alreadyDone = TaskCompletion::where('user_id', $user->id)
                ->whereDate('completed_date', today())
                ->exists();

            if ($alreadyDone) {
                throw new \DomainException('Task already completed today.');
            }

            $task = DailyTask::where('plan_id', $activePlan->plan_id)->where('status', 'active')->first();
            if (!$task) {
                throw new \DomainException('No active task available for this plan.');
            }

            $completion = TaskCompletion::create([
                'user_id' => $user->id,
                'task_id' => $task->id,
                'completed_date' => today(),
                'income_credited' => true,
                'created_at' => now(),
            ]);

            (new WalletService())->credit(
                $user,
                (float) $activePlan->plan->daily_task_income,
                'task_income',
                'Daily task completion #' . $task->id
            );

            return $completion;
        });
    }
}
