<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTrackCoinsColsColToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('self_assessment_coins_current')->after('self_assessment_coins')->default(0);
            $table->integer('daily_journal_coins_current')->after('daily_journal_coins')->default(0);
            $table->integer('habit_coins_current')->after('habit_coins')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('users', 'self_assesment_coins_current','daily_journal_coins_current','habit_coins_current')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn(['self_assesment_coins_current','daily_journal_coins_current','habit_coins_current']);
            });
        }
    }
}
