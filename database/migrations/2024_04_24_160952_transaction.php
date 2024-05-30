<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Transaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('transaction_id')->unique();
            $table->string('user_id');
            $table->string('wallet_id');
            $table->string('user_type'); //customer, driver
            $table->string('transaction_type'); // purchase, refund, transfer, etc
            $table->string('status'); //pending, completed, failed

            $table->float('previous_balance');
            $table->float('updated_balance');

            $table->string('currency');
            $table->string('description')->nullable();

            $table->unsignedBigInteger('payment_gateway_id')->nullable();
            $table->string('reference_id')->nullable();

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
        //
    }
}