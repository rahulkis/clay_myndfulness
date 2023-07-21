<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class HabitCategoryLink extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('habbits', function (Blueprint $table) {
            $table->foreignId("habit_category_id")->nullable()->constrained("habit_categories", "id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('habbits', function (Blueprint $table) {
            $table->dropColumn('habit_category_id');
        });
    }
}
