<?php

namespace Tests\Unit;

use App\Models\UserHabitRoutine;
use App\Models\UserRoutineTransaction;
use App\Services\UserHabitTransactionService;
use Illuminate\Foundation\Testing\Concerns\InteractsWithExceptionHandling;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserHabitRoutineTest extends TestCase
{
    use RefreshDatabase;
    use InteractsWithExceptionHandling;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_once_a_day_routine_create()
    {
        date_default_timezone_set('Asia/Kolkata');
        $this->travel(4)->hours();
        $time      = now()->format("H:i:s");
        $date_time = now(config("app.timezone"))->format("Y-m-d H:i:s");
        $this->travelBack();
        $data = [
            "habit_id"          => null,
            "habit"             => "Test Habit",
            "habit_description" => "Habit Description",
            "routine_time"      => $time,
            "routine_type"      => "Once a day",
            "user_id"           => 1,
            "active_status"     => true,
        ];
        $routine               = UserHabitRoutine::create($data);
        $entered_today_date    = date("Y-m-d ") . $data["routine_time"];
        $this->assertEquals(1, $routine->transactions()->count());
        $transaction = $routine->transactions()->first();
        $this->assertEquals($date_time, $transaction->remind_at);
    }

    public function test_twice_a_day_routine_create()
    {
        date_default_timezone_set('Asia/Kolkata');
        $this->travel(4)->hours();
        $time      = now()->format("H:i:s");
        $date1_time = now(config("app.timezone"))->format("Y-m-d H:i:s");
        $this->travel(12)->hours();
        $date2_time = now(config("app.timezone"))->format("Y-m-d H:i:s");
        $this->travelBack();
        $data = [
            "habit_id"          => null,
            "habit"             => "Test Habit",
            "habit_description" => "Habit Description",
            "routine_time"      => $time,
            "routine_type"      => "Twice a day",
            "user_id"           => 1,
            "active_status"     => true,
        ];
        $routine               = UserHabitRoutine::create($data);
        $transactions = UserRoutineTransaction::orderBy("remind_at")->get();
        $this->assertEquals(2, $transactions->count());

        $this->assertEquals($date1_time, $transactions->get(0)->remind_at);
        $this->assertEquals($date2_time, $transactions->get(1)->remind_at);

    }
    public function test_back_datetime_routine_create()
    {
        date_default_timezone_set('Asia/Kolkata');
        $this->travel(-2)->hours();
        $time      = now()->format("H:i:s");
        // next day
        $this->travel(24)->hours();
        $date1_time = now(config("app.timezone"))->format("Y-m-d H:i:s");
        // next day + 12 hour twice a day logic
        $this->travel(12)->hours();
        $date2_time = now(config("app.timezone"))->format("Y-m-d H:i:s");
        $this->travelBack();
        $data = [
            "habit_id"          => null,
            "habit"             => "Test Habit",
            "habit_description" => "Habit Description",
            "routine_time"      => $time,
            "routine_type"      => "Twice a day",
            "user_id"           => 1,
            "active_status"     => true,
        ];
        $routine               = UserHabitRoutine::create($data);
        $transactions = UserRoutineTransaction::orderBy("remind_at")->get();
        $this->assertEquals(2, $transactions->count());
        $this->assertEquals($date1_time, $transactions->get(0)->remind_at->format("Y-m-d H:i:s"));
        $this->assertEquals($date2_time, $transactions->get(1)->remind_at->format("Y-m-d H:i:s"));

    }

    public function test_thrice_a_day_routine_create()
    {
        date_default_timezone_set('Asia/Kolkata');
        // reminder 1
        $this->travel(4)->hours();
        $time      = now()->format("H:i:s");
        $date1_time = now(config("app.timezone"))->format("Y-m-d H:i:s");
        // reminder 2
        $this->travel(8)->hours();
        $date2_time = now(config("app.timezone"))->format("Y-m-d H:i:s");
        // reminder 3
        $this->travel(8)->hours();
        $date3_time = now(config("app.timezone"))->format("Y-m-d H:i:s");
        $this->travelBack();
        $data = [
            "habit_id"          => null,
            "habit"             => "Test Habit",
            "habit_description" => "Habit Description",
            "routine_time"      => $time,
            "routine_type"      => "Thrice a day",
            "user_id"           => 1,
            "active_status"     => true,
        ];
        $routine               = UserHabitRoutine::create($data);
        $transactions = UserRoutineTransaction::orderBy("remind_at")->get();
        $this->assertEquals(3, $transactions->count());
        $this->assertEquals($date1_time, $transactions->get(0)->remind_at);
        $this->assertEquals($date2_time, $transactions->get(1)->remind_at);
        $this->assertEquals($date3_time, $transactions->get(2)->remind_at);

    }
    public function test_fourth_times_a_day_routine_create()
    {
        date_default_timezone_set('Asia/Kolkata');
        // reminder 1
        $this->travel(4)->hours();
        $time      = now()->format("H:i:s");
        $date1_time = now(config("app.timezone"))->format("Y-m-d H:i:s");
        // reminder 2
        $this->travel(6)->hours();
        $date2_time = now(config("app.timezone"))->format("Y-m-d H:i:s");
        // reminder 3
        $this->travel(6)->hours();
        $date3_time = now(config("app.timezone"))->format("Y-m-d H:i:s");
        // reminder 4
        $this->travel(6)->hours();
        $date4_time = now(config("app.timezone"))->format("Y-m-d H:i:s");
        $this->travelBack();
        $data = [
            "habit_id"          => null,
            "habit"             => "Test Habit",
            "habit_description" => "Habit Description",
            "routine_time"      => $time,
            "routine_type"      => "Four times a day",
            "user_id"           => 1,
            "active_status"     => true,
        ];
        $routine               = UserHabitRoutine::create($data);
        $transactions = UserRoutineTransaction::orderBy("remind_at")->get();
        $this->assertEquals(4, $transactions->count());
        $this->assertEquals($date1_time, $transactions->get(0)->remind_at);
        $this->assertEquals($date2_time, $transactions->get(1)->remind_at);
        $this->assertEquals($date3_time, $transactions->get(2)->remind_at);
        $this->assertEquals($date4_time, $transactions->get(3)->remind_at);

    }
    public function test_once_every_two_day_routine_create_after_task_created()
    {
        date_default_timezone_set('Asia/Kolkata');
        $this->travel(4)->hours();
        $time      = now()->format("H:i:s");
        // reminder 1
        // $this->travel(48)->hours();
        $date1_time = now(config("app.timezone"))->format("Y-m-d H:i:s");

        $this->travelBack();
        $data = [
            "habit_id"          => null,
            "habit"             => "Test Habit",
            "habit_description" => "Habit Description",
            "routine_time"      => $time,
            "routine_type"      => "Once every two days",
            "user_id"           => 1,
            "active_status"     => true,
        ];
        $routine               = UserHabitRoutine::create($data);
        $routine->transactions()->update([
            'status' => UserRoutineTransaction::$COMPLETE_STATUS,
            'is_processed' => 1,
            'processed_at' => now()
        ]);
        // $service = new UserHabitTransactionService($routine, $routine->latest_trasaction->remind_at, false);
        // $service->createHabitTransactions();
        $transactions = UserRoutineTransaction::orderBy("id", "DESC")->first();
        $this->assertEquals($date1_time, $transactions->remind_at);

    }
    public function test_once_every_three_day_routine_create_after_task_created()
    {
        date_default_timezone_set('Asia/Kolkata');
        $this->travel(4)->hours();
        $time      = now()->format("H:i:s");
        // reminder 1
        $this->travel(24*3)->hours();
        $date1_time = now()->format("Y-m-d H:i:s");
        $this->travelBack();
        $data = [
            "habit_id"          => null,
            "habit"             => "Test Habit",
            "habit_description" => "Habit Description",
            "routine_time"      => $time,
            "routine_type"      => "Once every three days",
            "user_id"           => 1,
            "active_status"     => true,
        ];
        $routine               = UserHabitRoutine::create($data);
        $routine->transactions()->update([
            'status' => UserRoutineTransaction::$COMPLETE_STATUS,
            'is_processed' => 1,
            'processed_at' => now()
        ]);
        $service = new UserHabitTransactionService($routine, $routine->latest_trasaction->remind_at, false);
        $service->createHabitTransactions();
        $transactions = UserRoutineTransaction::orderBy("id", "DESC")->first();
        $this->assertEquals($date1_time, $transactions->remind_at);

    }
    public function test_once_every_four_day_routine_create_after_task_created()
    {
        date_default_timezone_set('Asia/Kolkata');
        $this->travel(4)->hours();
        $time      = now()->format("H:i:s");
        // reminder 1
        $this->travel(24*4)->hours();
        $date1_time = now()->format("Y-m-d H:i:s");
        $this->travelBack();
        $data = [
            "habit_id"          => null,
            "habit"             => "Test Habit",
            "habit_description" => "Habit Description",
            "routine_time"      => $time,
            "routine_type"      => "Once every four days",
            "user_id"           => 1,
            "active_status"     => true,
        ];
        $routine               = UserHabitRoutine::create($data);
        $routine->transactions()->update([
            'status' => UserRoutineTransaction::$COMPLETE_STATUS,
            'is_processed' => 1,
            'processed_at' => now()
        ]);
        $service = new UserHabitTransactionService($routine, $routine->latest_trasaction->remind_at, false);
        $service->createHabitTransactions();
        $transactions = UserRoutineTransaction::orderBy("id", "DESC")->first();
        $this->assertEquals($date1_time, $transactions->remind_at);

    }
    public function test_once_every_five_day_routine_create_after_task_created()
    {
        date_default_timezone_set('Asia/Kolkata');
        $this->travel(4)->hours();
        $time      = now()->format("H:i:s");
        // reminder 1
        $this->travel(24*5)->hours();
        $date1_time = now()->format("Y-m-d H:i:s");
        $this->travelBack();
        $data = [
            "habit_id"          => null,
            "habit"             => "Test Habit",
            "habit_description" => "Habit Description",
            "routine_time"      => $time,
            "routine_type"      => "Once every five days",
            "user_id"           => 1,
            "active_status"     => true,
        ];
        $routine               = UserHabitRoutine::create($data);
        $routine->transactions()->update([
            'status' => UserRoutineTransaction::$COMPLETE_STATUS,
            'is_processed' => 1,
            'processed_at' => now()
        ]);
        $service = new UserHabitTransactionService($routine, $routine->latest_trasaction->remind_at, false);
        $service->createHabitTransactions();
        $transactions = UserRoutineTransaction::orderBy("id", "DESC")->first();
        $this->assertEquals($date1_time, $transactions->remind_at);

    }
    public function test_once_every_seven_day_routine_create_after_task_created()
    {
        date_default_timezone_set('Asia/Kolkata');
        $this->travel(4)->hours();
        $time      = now()->format("H:i:s");
        // reminder 1
        $this->travel(24*7)->hours();
        $date1_time = now()->format("Y-m-d H:i:s");
        // reminder 2
        $this->travel(24*7)->hours();
        $date2_time = now()->format("Y-m-d H:i:s");
        $this->travelBack();
        // first test
        $data = [
            "habit_id"          => null,
            "habit"             => "Test Habit",
            "habit_description" => "Habit Description",
            "routine_time"      => $time,
            "routine_type"      => "Once every week",
            "user_id"           => 1,
            "active_status"     => true,
        ];
        $routine               = UserHabitRoutine::create($data);
        $routine->transactions()->update([
            'status' => UserRoutineTransaction::$COMPLETE_STATUS,
            'is_processed' => 1,
            'processed_at' => now()
        ]);
        $service = new UserHabitTransactionService($routine, $routine->latest_trasaction->remind_at, false);
        $service->createHabitTransactions();
        $transactions = UserRoutineTransaction::orderBy("id", "DESC")->first();
        $this->assertEquals($date1_time, $transactions->remind_at);
        // second test
        $routine->transactions()->update([
            'status' => UserRoutineTransaction::$COMPLETE_STATUS,
            'is_processed' => 1,
            'processed_at' => now()
        ]);
        $routine->refresh();
        $routine->load("latest_trasaction");
        $service = new UserHabitTransactionService($routine, $routine->latest_trasaction->remind_at, false);
        $service->createHabitTransactions();
        $transactions = UserRoutineTransaction::orderBy("id", "DESC")->first();
        $this->assertEquals($date2_time, $transactions->remind_at);

    }
    public function test_edit_habit_routine()
    {
        date_default_timezone_set("Asia/Kolkata");
        $this->travel(4)->hours();
        // first create
        $time      = now()->format("H:i:s");
        $date_time = now(config("app.timezone"))->format("Y-m-d H:i:s");
        $this->travel(-5)->hours();
        // second update
        $time2      = now()->format("H:i:s");
        $this->travel(24)->hours();
        $date_time2 = now(config("app.timezone"))->format("Y-m-d H:i:s");
        $this->travelBack();
        $data = [
            "habit_id"          => null,
            "habit"             => "Test Habit",
            "habit_description" => "Habit Description",
            "routine_time"      => $time,
            "routine_type"      => "Once a day",
            "user_id"           => 1,
            "active_status"     => true,
        ];
        $routine               = UserHabitRoutine::create($data);
        // $this->assertEquals(1, $routine->transactions()->count());
        // $transaction = $routine->transactions()->first();
        // $this->assertEquals($date_time, $transaction->remind_at);
        // update routine time

        // \DB::listen(function($query){
        //     dump($query->sql);
        // });
        // if ($routine->wasChanged('routine_time') or $routine->wasChanged('routine_type')) {
            $routine->transactions()->unProcessed()->delete();
        // }
        $routine->refresh()->update([
            "routine_time"  => $time2,
        ]);

        $routine->refresh();
        $service = new UserHabitTransactionService($routine, $routine->remind_at_date_time);
        $service->createHabitTransactions();

        $transaction = $routine->transactions()->unProcessed()->first();
        $transaction_count = $routine->transactions()->unProcessed()->count();
        $this->assertEquals(1, $transaction_count);
        $this->assertEquals($date_time2, $transaction->remind_at);
    }
}
