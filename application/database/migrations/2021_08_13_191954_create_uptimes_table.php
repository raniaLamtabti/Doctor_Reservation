<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUptimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uptimes', function (Blueprint $table) {
            $table->id();
            $table->time('morningFrom');
            $table->time('morningTo');
            $table->time('afternoonFrom');
            $table->time('afternoonTo');
            $table->time('eveningFrom');
            $table->time('eveningTo');
            $table->string('days');
            $table->unsignedBigInteger('doctor_id');
            $table->foreign('doctor_id')->references('id')->on('doctors');
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
        Schema::dropIfExists('uptimes');
    }
}
