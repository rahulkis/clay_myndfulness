<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\RewardService;
use Illuminate\Http\Request;

class RewardController extends Controller
{
    public function leaderboard(RewardService $service)
    {
        $leaderboard = $service->leaderboard();
        return view("rewards.leaderboard", compact("leaderboard"));
    }
}
