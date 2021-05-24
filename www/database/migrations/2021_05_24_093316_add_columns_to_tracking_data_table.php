<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToTrackingDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tracking_data', function (Blueprint $table) {
            $table->string('navigation_status', 20)->after('gps_timestamp')->default('')->comment('stato navigazione (pause, running, background...');
            $table->integer('connection_status')->after('navigation_status')->default(1)->comment('stato connessione (0:offline; 1:online');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tracking_data', function (Blueprint $table) {
            //
        });
    }
}
