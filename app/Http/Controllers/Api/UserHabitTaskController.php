<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HabitTask;
use App\Models\Task;
use App\Models\UserHabitTask;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DB;

class UserHabitTaskController extends Controller
{
    public function index()
    {
        /**
         * @var $user \App\Models\User
         */
        $user    = request()->user();
        $perPage = request("perPage");
        $tasks   = UserHabitTask::query()
            ->userFilter($user->id)
            ->pendings()
            ->paginate($perPage);
        return response()
            ->json($tasks);
    }
    public function completed(UserHabitTask $task)
    {
        $message = "Thank you for completing the habit.";
        return $this->changeStatus($task, UserHabitTask::$COMPLETE_STATUS, $message);
    }
    public function incomplete(UserHabitTask $task)
    {
        $message = "Successfully updated.";
        return $this->changeStatus($task, UserHabitTask::$INCOMPLETE_STATUS, $message, false);
    }
    private function changeStatus(UserHabitTask $task, $status, $message, $fire_event = true)
    {
        $user = auth("sanctum")->user();
        if ($user->id !== $task->user_id) {
            return response()
                ->json([
                    "message" => "Unauthorized access.",
                ], Response::HTTP_UNAUTHORIZED);
        }
        if($task->status != UserHabitTask::$PENDING_STATUS){
            return response()
            ->json([
                "message" => "FAILED. Habit is already ". $task->status,
            ], Response::HTTP_UNAUTHORIZED);
        }
        DB::transaction(function() use ($task, $status, $fire_event){
            $task->update(['status' => $status]);
            if($fire_event){
                $task->taskIsCompletedEvent();
            }
        });
        return response()
            ->json([
                "message" => $message,
            ], Response::HTTP_OK);
    }
}
