<?php

namespace App\Http\Controllers\Api\User;

use App\Helper\CommonHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\OnboardingQuestionResponse;
use App\Models\OnboardingResponse;
use App\Models\Question;
use DB;
use Illuminate\Http\Response;

class QuestionController extends Controller
{
    public function onBoardingQuestions()
    {
        return Question::all();
    }

    public function onBoardingQuestionResponse(OnboardingQuestionResponse $request)
    {
        try {
            $final_data = $request->prepareData();
        } catch (\Throwable$th) {
            report($th);
            abort(500, "Data preparation failed.");
        }
        /**
         * @var \App\Models\User $user
         */
        $user   = $request->user();
        if($user->is_onboard_completed){
            return CommonHelper::badRequestResponse("Onboarding already completed.");
        }
        DB::beginTransaction();
        try {
            $return = [];
            foreach ($final_data as $key => $data) {
                $response = OnboardingResponse::create([
                    "user_id"       => $user->id,
                    "question_id"   => $data["question_id"],
                    "question"      => $data["question"],
                    "question_type" => $data["type"],
                    "option_ids"    => $request->filterOptionIds($data["answers"]),
                    "options"       => collect($data["answers"])->pluck("text"),
                ]);
                $response->createUserHabit();
            }
        } catch (\Throwable$th) {
            report($th);
            DB::rollback();
            return response()
                ->json([
                    "message"   => "Whoops! something went wrong."
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        $user->is_onboard_completed = true;
        $user->save();
        DB::commit();
        return response()
            ->json([
                "message"   => "Successfully submitted."
            ], Response::HTTP_OK);
    }
}
