<?php

namespace App\Console\Commands;

use App\Console\Commands\Interfaces\DbOptimizedCommand;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Notifications\SwitchToFreePlanNotification;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;

class ExpiryPlanSwitchCommand extends Command implements DbOptimizedCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process:switch-plan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Switch plan to free if expired';

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
        $this->info('Execution running');
        $free_plan = SubscriptionPlan::free()->firstOrFail();
        foreach ($this->query()->cursor() as $key => $user) {
            /**
             * @var \App\Models\User $user
             */
            $user->deActivateAllHabit();
            $user->updateNewPlan($free_plan, now(), now()->addYear(5), now()->addYear(5)->addDays(3));
            $user->notify(new SwitchToFreePlanNotification($free_plan));
        }
        $this->info('Finished');
        return 0;
    }
    public function query(): Builder
    {
        return User::whereHas("activePlan")
            ->planExpired();
    }
}
