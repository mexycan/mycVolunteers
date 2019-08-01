<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clocks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->default(0);
            $table->integer('coordinator_id')->default(0);
            $table->string('area')->default('general');
            $table->string('status')->default('');
            $table->dateTime('clock_start')->nullable($value = true);
            $table->dateTime('clock_finish')->nullable($value = true);
            $table->dateTime('approved_at')->nullable($value = true);
            $table->float('hours')->default(0);
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
        Schema::dropIfExists('clocks');
    }
}
