<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserHabitRoutinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_habit_routines', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('habit_id', false);
            $table->bigInteger('user_id', false);
            $table->string('habit');
            $table->string('habit_description');
            $table->time('routine_time');
            $table->string('routine_type')->default("everyday")->comment("everyday");
            $table->boolean("active_status")->default(false)->comment("true = active, false = inactive");
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_habit_routines');
    }
}
