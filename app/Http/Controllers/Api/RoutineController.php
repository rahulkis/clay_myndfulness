<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\PlanLimitCrossedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserHabitRouteStoreRequest;
use App\Models\UserHabitRoutine;
use App\Models\UserRoutineTransaction;
use App\Services\UserHabitTransactionService;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RoutineController extends Controller
{
    public function index()
    {
        $per_page = request("per_page", 20);
        $user     = auth("sanctum")->user();
        $routines = UserHabitRoutine::query()
            ->with("habit_master")
            ->user($user->id)
            ->latest()
            ->paginate($per_page);
        return response()
            ->json($routines);
    }
    public function changeStatus(UserHabitRoutine $routine)
    {
        $user = auth("sanctum")->user();
        if ($user->id !== $routine->user_id) {
            return response()
                ->json([
                    "message" => "Unauthorized access.",
                ], Response::HTTP_UNAUTHORIZED);
        }
        if(!$routine->active_status){
            // plan chcking and throwing plan exceeded.
            /***
             * @var \App\Models\UserSubscription $active_plan
             */
            $active_plan = $user->activePlan;
            if($active_plan->isHabitLimitCrossed()){
                throw new PlanLimitCrossedException("Your habit limit of {$active_plan->habit_limit} is exceeded.");
            }
        }
        $routine->update([
            "active_status" => !$routine->active_status,
        ]);
        if($routine->active_status){
            $routine->transactions()->pending()->update([
                'status' => UserRoutineTransaction::$COMPLETE_STATUS,
                'is_processed' => 1,
                'processed_at' => now()
            ]);
            $service = new UserHabitTransactionService($routine, $routine->latest_trasaction->remind_at, false);
            $service->createHabitTransactions();
        }

        return response()
            ->json([
                "message" => "Updated successfully.",
            ], Response::HTTP_OK);
    }
    public function store(UserHabitRouteStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $data                  = $request->all();
            $data["user_id"]       = auth("sanctum")->id();
            $data["active_status"] = true;
            $routine               = UserHabitRoutine::create($data);
            $entered_today_date    = date("Y-m-d ") . $data["routine_time"];
            // if the selected time is not yet come
            // if (time() < strtotime($entered_today_date)) {
            //     $routine->createTransaction($entered_today_date);
            // }
        } catch (\Throwable $th) {
            DB::rollback();
            report($th);
            return response()
                ->json([
                    "message" => "Routine creation failed.",
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        DB::commit();
        return response()
            ->json([
                "message" => "Routine created.",
                "data"    => $routine,
            ]);
    }
    public function todaysRoutine()
    {
        $user     = auth("sanctum")->user();
        $routines = UserRoutineTransaction::todays()
            ->userFilter($user->id)
            ->paginate(20);
        return response()
            ->json(array_merge(["message" => $routines->total() . " records found"], $routines->toArray()));
    }
    public function destroy(UserHabitRoutine $user_habit)
    {
        $user = auth("sanctum")->user();
        if ($user->id !== $user_habit->user_id) {
            return response()
                ->json([
                    "message" => "Unauthorized access.",
                ], Response::HTTP_UNAUTHORIZED);
        }
        DB::beginTransaction();
        try {
            // please visit model boot method for other functions that happend on deleted.
            $user_habit->delete();
        } catch (\Throwable $th) {
            DB::rollback();
            return response()
                ->json([
                    "message" => "Whoops something went wrong.",
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        DB::commit();
        return response()
            ->json([
                "message" => "Deleted successfully.",
            ], Response::HTTP_OK);
    }
    public function update(UserHabitRoutine $routine, UserHabitRouteStoreRequest $request)
    {
        $user = auth("sanctum")->user();
        if ($user->id !== $routine->user_id) {
            return response()
                ->json([
                    "message" => "Unauthorized access.",
                ], Response::HTTP_UNAUTHORIZED);
        }
        // $request->validate();
        DB::transaction(function() use ($routine, $request){
            // if ($routine->wasChanged('routine_time') or $routine->wasChanged('routine_type')) {
            // }
            $routine->transactions()->unProcessed()->delete();
            $routine->update($request->validated());
            $routine->refresh();
            $service = new UserHabitTransactionService($routine, $routine->remind_at_date_time);
            $service->createHabitTransactions();
        });

        return response()
            ->json([
                "message" => "Updated successfully.",
            ], Response::HTTP_OK);
    }

    public function completeRoutineTransaction(UserRoutineTransaction $routine_transaction){
        $user = auth("sanctum")->user();
        if ($user->id !== $routine_transaction->user_id) {
            return response()
                ->json([
                    "message" => "Unauthorized access.",
                ], Response::HTTP_UNAUTHORIZED);
        }
        DB::transaction(function() use ($routine_transaction){
            $routine_transaction->update(['status' => UserRoutineTransaction::$COMPLETE_STATUS]);
            $routine_transaction->routineCompletedEvent();
        });

        return response()
            ->json([
                "message" => "Thank you for completing the routine.",
            ], Response::HTTP_OK);
    }
}
