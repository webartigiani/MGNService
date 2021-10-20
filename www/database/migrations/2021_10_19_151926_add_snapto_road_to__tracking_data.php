<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Facade\Ignition\IgnitionServiceProvider;

class AddSnaptoRoadToTrackingData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tracking_data', function (Blueprint $table) {
            $table->boolean('osrm_done')->after('connection_status')->nullable()->comment('punto corretto da sistema di rilevamento "nearest" (OSRM)');
            $table->float('osrm_distance')->after('osrm_done')->nullable()->comment('distanza in metri dal punto originale');
            $table->string('osrm_prev_latitude', 64)->after('osrm_distance')->nullable()->comment('posizione originale: latitude');
            $table->string('osrm_prev_longitude', 64)->after('osrm_prev_latitude')->nullable()->comment('posizione originale: longitude');
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
