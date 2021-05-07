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
            $table->integer('modo_timbratura')->default(0)->comment('modo timbratura. 0=tutte; 1=su veicolo; 2=senza veicolo');
            $table->string('password_timbratura', 10)->comment('la password del dipendente per la timbratura tramite APP o sito');
            $table->string('matricola', 30)->unique()->comment('numero di matricola del dipendente');
            $table->integer('stato')->default(0)->comment('stato. 0=fuori; 1=al lavoro');               // 0: fuori; 1: accesso
            $table->timestamp('data_stato')->nullable()->comment('data ultimo aggiornamento stato');        // data stato
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
