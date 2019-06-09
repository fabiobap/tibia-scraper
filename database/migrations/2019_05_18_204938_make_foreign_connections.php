<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeForeignConnections extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sightings', function (Blueprint $table) {
            $table->foreign('server_id')
                ->references('id')
                ->on('servers')->onDelete('set null');

            $table->foreign('boss_id')
                ->references('id')
                ->on('bosses')->onDelete('set null');
        });        
        Schema::table('predictionsbase', function (Blueprint $table) {

            $table->foreign('boss_id')
                ->references('id')
                ->on('bosses')->onDelete('set null');
        });
        
        Schema::table('predictions', function (Blueprint $table) {

        $table->foreign('boss_id')
                ->references('id')
                ->on('bosses')->onDelete('set null');
        
        $table->foreign('server_id')
                ->references('id')
                ->on('servers')->onDelete('set null');
    
        $table->foreign('sighting_id')
                ->references('id')
                ->on('sightings')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sightings', function (Blueprint $table) {
            $table->dropForeign(['server_id']);
            $table->dropForeign(['boss_id']);
            $table->dropColumn(['server_id','boss_id']);
        });
        Schema::table('predictionsbase', function (Blueprint $table) {
            $table->dropForeign(['boss_id']);
            $table->dropColumn(['boss_id']);
        });
        Schema::table('predictions', function (Blueprint $table) {
            $table->dropForeign(['server_id']);
            $table->dropForeign(['boss_id']);
            $table->dropForeign(['sighting_id']);
            $table->dropColumn(['server_id','boss_id','sighting_id']);
        });
    }
}
