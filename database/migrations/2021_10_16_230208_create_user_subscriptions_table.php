<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained("users");
            $table->foreignId('subscription_plan_id')->constrained("subscription_plans");
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
            $table->timestamp('start_date');
            $table->timestamp('end_date');
            $table->timestamp('after_grace_period_date');
            $table->boolean('is_active')->default(true);
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
        Schema::dropIfExists('user_subscriptions');
    }
}
