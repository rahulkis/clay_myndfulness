<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Services\QuestionService;

class BootApiController extends Controller
{
    public function boot()
    {
        return response()
            ->json([
                "onboarding"    => QuestionService::onBoardingQuestion(),
                "routine_types" => config("modules.routine_types"),
            ], 200);
    }
}
