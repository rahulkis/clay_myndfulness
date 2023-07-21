<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserTableModificationsSocialAuth extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('social_id')->after("id");
            $table->string('social_auth_type')->after("social_id");
            $table->string('avatar')->nullable()->after("social_auth_type");
            $table->tinyInteger("is_onboard_completed")->default(0)->after("avatar");
            $table->bigInteger('habit_medals', false)->default(0)->after("remember_token");
            $table->bigInteger('habit_coins', false)->default(0)->after("habit_medals");
            $table->bigInteger('self_assessment_medals', false)->default(0)->after("habit_coins");
            $table->bigInteger('self_assessment_coins', false)->default(0)->after("self_assessment_medals");
            $table->bigInteger('daily_journal_medals', false)->default(0)->after("self_assessment_coins");
            $table->bigInteger('daily_journal_coins', false)->default(0)->after("daily_journal_medals");
            $table->bigInteger('total_medals', false)->default(0)->after("daily_journal_coins");
            $table->bigInteger('total_coins', false)->default(0)->after("total_medals");
            $table->softDeletes()->after("updated_at");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['social_auth_type', "avatar", "is_onboard_completed", "deleted_at",
                "is_onboard_completed", "habit_medals", "habit_coins", "self_assessment_medals", "self_assessment_coins",
                "self_assessment_coins", "daily_journal_medals", "daily_journal_coins", "total_medals", "total_coins"]);
        });
    }
}
