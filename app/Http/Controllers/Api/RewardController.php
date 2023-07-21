<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reward;
use App\Models\UserHabitRoutine;
use App\Services\RewardService;

class RewardController extends Controller
{
    public function leaderboard(RewardService $service)
    {
        return response()
            ->json([
                "message" => "Success",
                "data"    => $service->leaderboard(),
            ]);
    }
    public function achievement()
    {
        $user = request()->user();
        $data = Reward::query()
            ->select(\DB::raw("sum(total_reward) as total_reward"), "rewardable_id", "rewardable_type", "type")
            ->with("rewardable:id,habit_id,habit,habit_description,active_status")
            ->where("rewardable_type", UserHabitRoutine::class)
            ->groupBy("rewardable_id","rewardable_type","type")
            ->userFilter($user->id)
            // ->latest()
            ->get();
        return response()
            ->json([
                "message" => "Success",
                "data"    => $data,
            ]);
    }
}
