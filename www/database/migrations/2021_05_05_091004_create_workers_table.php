<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workers', function (Blueprint $table) {
            $table->id();
            $table->integer('codice_azienda')->default(228)->comment('codice azienda. sempre 228');
            $table->string('denominazione_azienda', 128)->comment('denominazione azienda');
            $table->string('cognome', 64)->comment('cognome del dipendente');
            $table->string('nome', 64)->comment('nome del dipendente');
            $table->string('codice_fiscale', 16)->unique()->comment('codice fiscale del dipendente');
            $table->date('data_assunzione')->comment('data assunzione del dipendente');
            $table->date('data_cessazione')->nullable()->comment('data cessazione rapporto di lavoro');
            $table->integer('modo_timbratura')->default(0)->comment('modo timbratura. 0=tutte; 1=con veicolo aziendale; 2=con veicolo personale');
            $table->string('password_timbratura', 10)->comment('la password del dipendente per la timbratura tramite APP o sito');
            $table->string('matricola', 30)->unique()->comment('numero di matricola del dipendente');
            $table->integer('ore_settimanali')->default(31)->comment('numero ore settimanali da contratto');
            $table->integer('stato')->default(0)->comment('stato. 0=fuori; 1=al lavoro');                   // 0: fuori; 1: accesso
            $table->timestamp('data_stato')->nullable()->comment('data ultimo aggiornamento stato');        // data stato
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
        Schema::dropIfExists('workers');
    }
}
