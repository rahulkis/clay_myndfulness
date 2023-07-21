<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsProcessedToUserRoutineTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_routine_transactions', function (Blueprint $table) {
            $table->boolean('is_processed')->default(false)->after('status');
            $table->timestamp('processed_at')->nullable()->after('is_processed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('user_routine_transactions', 'is_processed','processed_at')) {
            Schema::table('user_routine_transactions', function (Blueprint $table) {
                $table->dropColumn(['is_processed','processed_at']);
            });
        }
    }
}
