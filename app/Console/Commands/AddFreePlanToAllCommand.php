<?php

namespace App\Console\Commands;

use App\Console\Commands\Interfaces\DbOptimizedCommand;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;

class AddFreePlanToAllCommand extends Command implements DbOptimizedCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process:free-plan-all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add free plan to those users who doesnt have any plan yet.';

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
        $this->info("Command running.");
        foreach ($this->query()->cursor() as $key => $user) {
            $free_plan = SubscriptionPlan::free()->firstOrFail();
            foreach ($this->query()->cursor() as $key => $user) {
                /**
                 * @var \App\Models\User $user
                 */
                $user->updateNewPlan($free_plan, now(), now()->addYear(5), now()->addYear(5)->addDays(3));
            }
        }
        $this->info('Finished');
        return 0;
    }
    public function query(): Builder
    {
        return User::doesnthaveAnyPlan();
    }
}
