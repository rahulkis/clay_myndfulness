<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRoutineTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_routine_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_habit_routine_id');
            $table->unsignedBigInteger('user_id');
            $table->string('habit', 255);
            $table->text('habit_description');
            $table->dateTime("remind_at");
            $table->string('status', 100)->default('pending')->commnet("pending,expired,completed,incompleted");
            $table->dateTime('status_updated_at')->nullable();
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
        Schema::dropIfExists('user_routine_transactions');
    }
}
