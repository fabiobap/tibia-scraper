<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBossSighting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sightings', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->softDeletes();
            $table->bigIncrements('id');
            $table->timestamps();
            $table->bigInteger('server_id')->nullable()->unsigned();
            $table->bigInteger('boss_id')->nullable()->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sightings');
    }
}
