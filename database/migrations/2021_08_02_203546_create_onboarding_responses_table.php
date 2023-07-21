<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOnboardingResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('onboarding_responses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id', false);
            $table->bigInteger('question_id', false);
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
        Schema::dropIfExists('onboarding_responses');
    }
}
