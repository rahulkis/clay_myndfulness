<?php

namespace App\Services;

use App\Models\UserHabitRoutine;
use App\Models\UserRoutineTransaction;
use Carbon\Carbon;
use Exception;

class UserHabitTransactionService
{
    public $routine;
    public $start_time;
    public $startnewly_created_routine_time;
    public function __construct(UserHabitRoutine $routine, Carbon $start_time, $newly_created_routine = true)
    {
        $this->routine    = $routine;
        $this->start_time = $start_time;
        $this->newly_created_routine = $newly_created_routine;
    }
    public function createHabitTransactions()
    {
        $configs = $this->getConfigs();
        $this->createTransactions($configs);
    }
    private function createTransactions($configs)
    {
        $date_time = $this->start_time;
        // if time is already passed create from next day
        if($date_time < now()){
            // dump("old date", $date_time);
            $date_time = $date_time->addHour(24);
            // dd("new date", $date_time);
        }
        // subsctracting and adding same hour is no issue.
        // for
        if($this->newly_created_routine){
            $date_time = $date_time->subHour($configs[1]);
        }
        $data = [];
        for ($i = 0; $i < $configs[0]; $i++) {
            $date_time = $date_time->addHour($configs[1]);
            if($date_time->getTimezone()->getName() != "UTC" && $this->newly_created_routine){
                $date_time = $date_time->timezone(config("app.timezone"));
            }

            $data[] = [
                'user_id'           => $this->routine->user_id,
                'habit'             => $this->routine->habit,
                'habit_description' => $this->routine->habit_description,
                'remind_at'         => $date_time->format('Y-m-d H:i:s'),
                "status"            => UserRoutineTransaction::$PENDING_STATUS,
            ];
            // $date_time = $date_time->addHour($configs[1]);
            // dump($date_time->format('Y-m-d H:i:s'));
        }
        $this->routine->transactions()->createMany($data);
    }
    private function getConfigs()
    {
        $total_transactions = 0;
        $duration_hours     = 0;
        switch ($this->routine->routine_type) {
            case 'Once a day':
                $total_transactions = 1;
                $duration_hours     = 24 / 1;
                break;
            case 'Twice a day':
                $total_transactions = 2;
                $duration_hours     = 24 / 2;
                break;
            case 'Thrice a day':
                $total_transactions = 3;
                $duration_hours     = 24 / 3;
                break;
            case 'Four times a day':
                $total_transactions = 4;
                $duration_hours     = 24 / 4;
                break;
            case 'Once every two days':
                $total_transactions = 1;
                $duration_hours     = 24 * 2;
                break;
            case 'Once every three days':
                $total_transactions = 1;
                $duration_hours     = 24 * 3;
                break;
            case 'Once every four days':
                $total_transactions = 1;
                $duration_hours     = 24 * 4;
                break;
            case 'Once every five days':
                $total_transactions = 1;
                $duration_hours     = 24 * 5;
                break;
            case 'Once every six days':
                $total_transactions = 1;
                $duration_hours     = 24 * 6;
                break;
            case 'Once every week':
                $total_transactions = 1;
                $duration_hours     = 24 * 7;
                break;
            default:
                throw new Exception("Bad routine type. ". $this->routine->routine_type." is invalid.");
                break;
        }
        return [$total_transactions, $duration_hours];
    }
}
