<?php
namespace App\Services;

use App\Helper\CommonHelper;
use App\Models\Reward;
use DB;
use Illuminate\Support\Collection;

class RewardService
{
    public function leaderboard() : array
    {
        return [
            "this_week" => $this->thisWeekLeaderboards(),
            "this_month" => $this->thisMonthLeaderboards(),
            "this_year" => $this->thisYearLeaderboards(),
            "lifetime" => $this->lifetimeLeaderboards(),
        ];
    }
    private function thisWeekLeaderboards() : Collection
    {
        return $this->leaderBoardFilter(CommonHelper::currentWeekDates());
    }
    private function thisMonthLeaderboards() : Collection
    {
        return $this->leaderBoardFilter(CommonHelper::currentMonthDates());
    }
    private function thisYearLeaderboards() : Collection
    {
        return $this->leaderBoardFilter(CommonHelper::currentYearDates());
    }
    private function lifetimeLeaderboards() : Collection
    {
        return $this->leaderBoardFilter();
    }
    private function leaderBoardFilter($dates = null){
        return Reward::query()
        ->select("users.name", "users.email", "users.id", DB::raw("sum(total_reward) as total_medal"))
        // ->with("user")
        ->when($dates, function($query) use ($dates){
            $query->whereBetween("rewarded_at", $dates);
        })
        ->addSelect([
            "total_coin"    => Reward::query()
                ->select(DB::raw("sum(total_reward) as total_coin"))
                ->where("type", Reward::$REWARD_COIN_TYPE)
                ->when($dates, function($query) use ($dates){
                    $query->whereBetween("rewarded_at", $dates);
                })
                ->whereColumn("user_id", "rewards.user_id")
        ])
        ->groupBy("user_id")
        ->join("users", "rewards.user_id", "=", "users.id")
        ->where("type", Reward::$REWARD_MEDAL_TYPE)
        ->orderBy("total_medal")
        ->orderBy("total_coin")
        ->limit(Reward::$LEADERBOARD_LIMIT)
        ->get();
    }
}
