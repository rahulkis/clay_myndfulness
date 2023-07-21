<?php

namespace App\Console\Commands;

use App\Console\Commands\Interfaces\DbOptimizedCommand;
use App\Models\UserHabitTask;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;

class AutoTaskExpireChecking extends Command implements DbOptimizedCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process:task-exipred-checking';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $this->query()->update([
            "status"    => UserHabitTask::$EXPIRED_STATUS
        ]);
        return 1;
    }
    public function query(): Builder
    {
       return UserHabitTask::where("created_at", "<", now()->subHour(24));
    }
}
