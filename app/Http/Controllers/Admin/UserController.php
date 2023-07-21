<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DailyJournalReponse;
use App\Models\SelfAssessmentResponse;
use App\Models\User;
use App\Models\UserHabitRoutine;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile(User $user)
    {
        $user->load("onboarding_responses")->load('activePlan');
        $habbits_active = UserHabitRoutine::user($user->id)->active()->count();
        $habbits_total = UserHabitRoutine::user($user->id)->count();
        $self_assesment_count = SelfAssessmentResponse::userFilter($user->id)->count();
        $daily_journal_count = DailyJournalReponse::userFilter($user->id)->count();
        $data = [
            "user",
            "habbits_active",
            "habbits_total",
            "self_assesment_count",
            "daily_journal_count"
        ];
        return view("users.profile", compact($data));
    }
}
