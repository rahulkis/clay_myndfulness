<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class HabitIdNullableRoutine extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_habit_routines', function (Blueprint $table) {
            $table->unsignedBigInteger('habit_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_habit_routines', function (Blueprint $table) {
            $table->unsignedBigInteger('habit_id')->nullable(false)->change();
        });
    }
}
