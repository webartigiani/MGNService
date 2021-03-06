<?php

use Egulias\EmailValidator\Warning\Comment;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVeichlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('veichles', function (Blueprint $table) {
            $table->id();
            $table->string('manufacter', 128)->comment('marca veicolo');
            $table->string('model', 128)->comment('modello veicolo');
            $table->string('licence_plate', 10)->unique()->comment('numero di targa (unique)');
            $table->integer('status')->default(0)->comment('stato del veicolo. 0=in sede; 1=fuori sede');
            $table->timestamp('status_date')->nullable()->comment('data/ora ultima modifica stato');
            $table->integer('device')->nullable()->comment('device attualmente in uso: devices.id');
            $table->integer('worker')->nullable()->comment('dipendente a bordo. workers.id');
            $table->boolean('enabled')->default(true)->comment('abilitato/disabilitato da Admin');
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
        Schema::dropIfExists('veichles');
    }
}
