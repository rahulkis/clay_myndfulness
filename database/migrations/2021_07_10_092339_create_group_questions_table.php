<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_questions', function (Blueprint $table) {
            $table->id();
            $table->integer('group_question_option_id')->nullable();
            $table->integer('prev_group_question_id')->nullable();
            $table->integer('question_id');
            $table->integer('question_group_id');
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
        Schema::dropIfExists('group_questions');
    }
}
