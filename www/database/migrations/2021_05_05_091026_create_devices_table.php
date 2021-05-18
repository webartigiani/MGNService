<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('platform', 128)->comment('piattaforma/OS dispositivo');
            $table->string('version', 10)->comment('versione del SO del device');
            $table->string('manufacter', 128)->comment('marca del device');
            $table->string('model', 128)->comment('modello del device');
            $table->boolean('is_virtual')->default(false)->comment('true se device virtuale');
            $table->string('serial', 128)->comment('numero di serie del device (unique)');
            $table->string('uuid', 128)->unique()->comment('uuid del device (unique)');
            $table->boolean('is_online')->default(false)->comment('true se attualmente online su APP');
            $table->string('connection_type', 20)->comment('tipo di connessione');
            $table->string('app_version', 10)->comment('numero versione APP');
            $table->boolean('enabled')->default(true)->comment('abilitato/disabilitato da admin');
            $table->integer('status')->default(0)->comment('stato. 0: libero; 1 in tracking');                   // 0: libero; 1 in tracking
            $table->timestamp('status_date')->nullable()->comment('data ultimo aggiornamento stato');        // data stato
            $table->string('tracking_session', 20)->nullable()->default('')->comment('id sessione geo-localizzazione. geo_tracking.session_id');
            $table->string('latitude', 64)->nullable()->comment('ultima posizione rilevata: latitude');
            $table->string('longitude', 64)->nullable()->comment('ultima posizione rilevata: longitude');
            $table->integer('accuracy')->nullable()->comment('ultime posizione rilevata: accuratezza in metri');
            $table->timestamp('last_position')->nullable()->comment('data/ora rilevamento ultima posizione');
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
        Schema::dropIfExists('devices_');
    }
}
