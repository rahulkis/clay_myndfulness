<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyJournalResponseTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_journal_response_transactions', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('daily_journal_reponse_id')->constrained("daily_journal_reponses", "id");
            $table->unsignedBigInteger("daily_journal_reponse_id", false);
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
        Schema::dropIfExists('daily_journal_response_transactions');
    }
}
