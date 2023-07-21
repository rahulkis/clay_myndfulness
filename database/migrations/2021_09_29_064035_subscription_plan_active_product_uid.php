<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SubscriptionPlanActiveProductUid extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subscription_plans', function (Blueprint $table) {
            $table->string('product_uid', 100)->nullable()->after("id");
            $table->string('status', 50)->default("active")->comment("active, inactive")->after("daily_journal_limit");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subscription_plans', function (Blueprint $table) {
            $table->dropColumn([
                'subscription_plans',
                'product_uid',
                'status',
            ]);
        });
    }
}
