<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionPacakgesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->text("description");
            $table->integer("is_paid")->default(true)->comment("true for paid, false for free");
            $table->decimal("price")->default(0.00);
            $table->integer("duration", false)->comment("validity in days.");
            $table->tinyInteger("is_habit_limited")->default(false)->comment("true for limited, false for unlimited");
            $table->integer("habit_limit")->default(0);
            $table->tinyInteger("is_self_assessment_limited")->default(false)->comment("true for limited, false for unlimited");
            $table->integer("self_assessment_limit")->default(0);
            $table->tinyInteger("is_daily_journal_limited")->default(false)->comment("true for limited, false for unlimited");
            $table->integer("daily_journal_limit")->default(0);
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
        Schema::dropIfExists('subscription_pacakges');
    }
}
