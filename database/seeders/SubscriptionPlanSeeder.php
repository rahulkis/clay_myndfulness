<?php

namespace Database\Seeders;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = [
            [
                "name"                       => "Free",
                "description"                => "Free subscription for lifetime",
                "is_paid"                    => false, //
                "price"                      => 0.00,
                "duration"                   => 0, // if zero unlimited logic to be implimented
                "is_habit_limited"           => true, // false means unlimited
                "habit_limit"                => 1,
                "is_self_assessment_limited" => true,
                "self_assessment_limit"      => 0,
                "is_daily_journal_limited"   => true,
                "daily_journal_limit"        => 0,
            ],
            [
                "name"                       => "7 day trial",
                "description"                => "7 day trial version. Unlock all features.",
                "is_paid"                    => false, //
                "price"                      => 0.00,
                "duration"                   => 7, // if zero unlimited logic to be implimented
                "is_habit_limited"           => false,
                "habit_limit"                => 0,
                "is_self_assessment_limited" => false,
                "self_assessment_limit"      => 0,
                "is_daily_journal_limited"   => false,
                "daily_journal_limit"        => 0,
            ],
            [
                "name"                       => "Premium subscription",
                "description"                => "Primium subscription. Unlock all feautre",
                "is_paid"                    => true, //
                "price"                      => 100.00, // all in dollar
                "duration"                   => 365, // if zero unlimited logic to be implimented
                "is_habit_limited"           => false,
                "habit_limit"                => 0,
                "is_self_assessment_limited" => false,
                "self_assessment_limit"      => 0,
                "is_daily_journal_limited"   => false,
                "daily_journal_limit"        => 0,
            ],
        ];
        foreach ($array as $data) {
            SubscriptionPlan::create($data);
        }
    }
}
