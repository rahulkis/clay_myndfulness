<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserHabitTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_habit_tasks', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_habit_routine_id', false);
            $table->bigInteger('user_id', false);
            $table->string('habit_name')->nullable();
            $table->string('description')->nullable();
            $table->string('status', 100)->default('pending')->comment("pending, completed, expired, incompleted");
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
        Schema::dropIfExists('user_habit_tasks');
    }
}
