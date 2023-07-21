<?php

namespace App\Console\Commands;

use App\Console\Commands\Interfaces\DbOptimizedCommand;
use App\Models\UserSubscription;
use App\Notifications\PlanExpiryNotification;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;

class PaymentRenewReminder extends Command implements DbOptimizedCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process:plan_expiry_notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check expiry date of plan and send notification.';

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
        $this->info("Process started");
        foreach ($this->query()->cursor() as $key => $row) {
            $row->user->notify(new PlanExpiryNotification($row));
        }
        $this->info("Successfully executed.");
        return 0;
    }
    public function query() : Builder
    {
        return UserSubscription::active()
            ->with("user")
            ->paid()
            ->whereRaw("end_date <= DATE_ADD(CURDATE(), INTERVAL ? DAY)", [config("modules.NOTIFICATION_GRACE_DAY")])
            ->whereRaw("end_date >= DATE(now())");
    }
}
