<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NotifiedAtUserRoutineTransaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_routine_transactions', function (Blueprint $table) {
            $table->timestamp('notified_at')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_routine_transactions', function (Blueprint $table) {
            $table->dropColumn('notified_at');
        });
    }
}
