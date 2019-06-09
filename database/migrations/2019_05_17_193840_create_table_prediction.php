<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePrediction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('predictions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->bigInteger('boss_id')->nullable()->unsigned();
            $table->bigInteger('server_id')->nullable()->unsigned();
            $table->bigInteger('sighting_id')->nullable()->unsigned();
            $table->integer('minDays');
            $table->integer('avgDays');
            $table->integer('maxDays');
            $table->dateTime('nextSighting')->nullable();
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
        Schema::dropIfExists('table_prediction');
    }
}
