<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Orderstable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customer');
            $table->dateTime('order_date');
            $table->decimal('total_amount', 10, 2);
            $table->enum('payment_status', ['paid', 'pending', 'refunded'])->default('pending');
            $table->text('shipping_address');
            $table->text('billing_address');
            $table->enum('order_status', ['processing', 'shipped', 'delivered', 'canceled'])->default('processing');
            $table->string('payment_method');
            $table->string('shipping_method');
            $table->text('notes')->nullable();
            $table->decimal('discounts', 10, 2)->default(0);
            $table->string('promo_code')->nullable();
            $table->string('referral_source')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function ordersdown()
    {
        Schema::dropIfExists('orders');
    }
}