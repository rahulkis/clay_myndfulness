<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInAppPaymentTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('in_app_payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('type',10)->comment('apple,google');
            $table->text('receipt');
            $table->boolean('is_valid')->default(false);
            $table->string('product_uid')->nullable();
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
        Schema::dropIfExists('in_app_payment_transactions');
    }
}
