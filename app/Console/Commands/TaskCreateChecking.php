<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Console\Commands\Interfaces\DbOptimizedCommand;
use App\Models\UserHabitRoutine;
use App\Models\UserRoutineTransaction;
use App\Services\UserHabitTransactionService;
use Illuminate\Database\Eloquent\Builder;

class TaskCreateChecking extends Command implements DbOptimizedCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process:task-creation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process all routine transactions and create task.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->query()->chunk(200, function($routines){
            foreach($routines as $routine){
                /**
                 * @var \App\Models\UserHabitRoutine $routine
                 */
                $task = $routine->createTask();
                if($task){
                    $routine->notified_transactions()->update([
                        'status' => UserRoutineTransaction::$COMPLETE_STATUS,
                        'is_processed' => 1,
                        'processed_at' => now()
                    ]);
                    $service = new UserHabitTransactionService($routine, $routine->latest_trasaction->remind_at, false);
                    $service->createHabitTransactions();
                }
            }
        });
        return 1;
    }
    public function query(): Builder
    {
        return UserHabitRoutine::query()
            ->with("latest_trasaction")
            ->whereDoesntHave("future_upcoming_transactions")
            ->whereHas("notified_transactions")
            ->whereHas("belongs_user");
    }
}
