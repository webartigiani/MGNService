<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrackingDataExport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracking_data_export', function (Blueprint $table) {
            $table->id();
            $table->string('session_id', 20)->comment('id sessione tracciamento GPS: tracking_sessions.session_id');
            $table->string('latitude', 64)->nullable()->comment('ultima posizione rilevata: latitude');
            $table->string('longitude', 64)->nullable()->comment('ultima posizione rilevata: longitude');
            $table->integer('accuracy')->nullable()->comment('ultime posizione rilevata: accuratezza in metri');
            $table->float('distance')->default(0)->comment('distanza dalla posizione precedente');
            $table->boolean('is_valid')->default(true)->comment('posizione valida/non valida');
            $table->string('gps_timestamp', 20)->comment('timestamp da servizio geo-localizzazione');
            $table->string('navigation_status', 20)->default('')->comment('stato navigazione (pause, running, background...');
            $table->integer('connection_status')->default(1)->comment('stato connessione (0:offline; 1:online');
            $table->boolean('osrm_done')->nullable()->comment('punto corretto da sistema di rilevamento "nearest" (OSRM)');
            $table->float('osrm_distance')->nullable()->comment('distanza in metri dal punto originale');
            $table->string('osrm_prev_latitude', 64)->nullable()->comment('posizione originale: latitude');
            $table->string('osrm_prev_longitude', 64)->nullable()->comment('posizione originale: longitude');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tracking_data_export');
    }
}
