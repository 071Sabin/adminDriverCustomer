<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Mesgbroadcast extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('broadcast', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('adminId');
            $table->string('broadcast_title');
            $table->string('broadcast_type'); // primary, rgent will be of different color each
            $table->string('for'); //either customer or driver
            $table->string('message');

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