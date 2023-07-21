<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\DailyJournalStoreRequest;
use App\Models\DailyJournalReponse;
use App\Services\QuestionService;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DailyJournalController extends Controller
{
    public function index()
    {
        $per_page        = request("per_page", 20);
        $user            = auth("sanctum")->user();
        $daily_responses = DailyJournalReponse::query()
            ->with("transactions")
            ->userFilter($user->id)
            ->latest()
            ->paginate($per_page);
        return response()
            ->json($daily_responses);
    }
    public function store(DailyJournalStoreRequest $request)
    {
        try {
            $final_data = $request->prepareData();
        } catch (\Throwable $th) {
            report($th);
            abort(500, "Data preparation failed.");
        }
        /**
         * @var \App\Models\User $user
         */
        $user                     = $request->user();
        $is_already_entered_today = DailyJournalReponse::userFilter($user->id)
            ->whereDate("created_at", date("Y-m-d"))
            ->exists();

        DB::beginTransaction();
        try {
            $is_450_charcter_condition_passed = false;
            $daily_journal = DailyJournalReponse::create([
                "user_id"       => $user->id,
                "response_date" => now()->format("Y-m-d"),
                "json_response" => $request->all(),
            ]);
            $transactions_data = [];
            foreach ($final_data as $key => $data) {
                $transactions_data[] = [
                    "user_id"       => $user->id,
                    "question_id"   => $data["question_id"],
                    "question"      => $data["question"],
                    "question_type" => $data["type"],
                    "option_ids"    => $request->filterOptionIds($data["answers"]),
                    "options"       => collect($data["answers"])->pluck("text"),
                ];
                foreach($data["answers"] as $row){
                    $text_without_spaces = str_replace(" ", "", $row["text"]);
                    if(strlen($text_without_spaces) >= 300){
                        $is_450_charcter_condition_passed = true;
                    }
                }
            }
            $daily_journal->transactions()->createMany($transactions_data);
            if (!$is_already_entered_today) {
                $total_reward = DailyJournalReponse::MIN_COIN_PER_RESPONSE;
                if($is_450_charcter_condition_passed){
                    $total_reward += 1;
                }
                $reward_type = ($user->daily_journal_coins_current + $total_reward) >= DailyJournalReponse::COIN_LIMIT_FOR_MEDAL ? 'medal' : 'coin';
                $daily_journal->rewards()->create([
                    'user_id'      => $user->id,
                    'rewarded_at'  => date('Y-m-d'),
                    'total_reward' => $total_reward,
                    'type'         => $reward_type,
                ]);

            }

        } catch (\Throwable $th) {
            report($th);
            DB::rollback();
            return response()
                ->json([
                    "message" => "Whoops! something went wrong.",
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        DB::commit();
        $daily_journal->load("transactions");
        return response()
            ->json([
                "message" => "Daily journal submitted.",
                "data"    => $daily_journal,
            ], Response::HTTP_OK);
    }
    public function destroy(DailyJournalReponse $response)
    {
        $user = auth("sanctum")->user();
        if ($user->id !== $response->user_id) {
            return response()
                ->json([
                    "message" => "Unauthorized access.",
                ], Response::HTTP_UNAUTHORIZED);
        }
        DB::transaction(function() use ($response){
            $response->delete();
            $response->transactions()->delete();
        });
        return response()
            ->json([
                "message" => "Daily Journal Deleted.",
            ], Response::HTTP_OK);
    }
    public function questions()
    {
        return response()
            ->json([
                "data" => QuestionService::dailyJournalQuestions(),
            ], 200);
    }
}
