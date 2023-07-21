<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSelfAssessmentResponseTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('self_assessment_response_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('self_assessment_response_id', false);
            $table->unsignedBigInteger('question_id', false);
            $table->string('question_type', 100);
            $table->string('question');
            $table->json('options');
            $table->json('option_ids')->nullable();
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
        Schema::dropIfExists('self_assessment_response_transactions');
    }
}
