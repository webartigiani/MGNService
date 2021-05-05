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
            $table->integer('codice_azienda')->default(228);
            $table->string('denominazione_azienda', 128);
            $table->string('cognome', 64);
            $table->string('nome', 64);
            $table->string('codice_fiscale', 16)->unique();
            $table->date('data_assunzione');
            $table->date('data_cessazione')->nullable();
            $table->integer('modo_timbratura')->default(0);
            $table->string('matricola', 30)->nullable();
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
