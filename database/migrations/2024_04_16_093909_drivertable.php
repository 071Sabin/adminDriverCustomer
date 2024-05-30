<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Drivertable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('driverId')->unique();

            $table->integer('approved_status')->default(0);
            $table->integer('verification_status')->default(0);
            $table->integer('kyc_rejection')->nullable();

            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('verification_type')->nullable();
            $table->string('verification_file')->nullable();
            $table->string('profile_pic')->nullable();

            $table->timestamp('email_verified_at')->nullable();

            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function driverdown()
    {
        Schema::dropIfExists('driver');
    }
}