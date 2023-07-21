<?php

namespace App\Console\Commands;

use App\Console\Commands\Interfaces\DbOptimizedCommand;
use App\Models\UserRoutineTransaction;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;

class SendRoutineReminderNotification extends Command implements DbOptimizedCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process:routine-reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminder notification and update notified at.';

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

        $this->query()->chunk(200, function($routine_transactions){
            foreach($routine_transactions as $routine_transaction){
                $routine_transaction->sendReminder();
            }
        });
        return 1;
    }

    public function query(): Builder
    {
        return UserRoutineTransaction::query()
            ->with("user", "user_habit")
            ->whereHas("user")
            ->whereHas("active_user_habit")
            ->where("remind_at", "<=", now()->addSecond(30))
            ->pending();
    }
}
