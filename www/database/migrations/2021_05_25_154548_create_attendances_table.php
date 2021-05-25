<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->integer('worker')->default(0)->comment('id dipendente. workers.id');
            $table->timestamp('entrance_date')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('data/ora timbrata entrata');    // data timbrata entrata
            $table->string('entrance_ip', 20)->default('')->comment('indirizzo IP timbratura entrata');
            $table->string('entrance_latitude', 64)->nullable()->comment('posizione rilevata timbratura entrata: latitude');
            $table->string('entrance_longitude', 64)->nullable()->comment('posizione rilevata timbratura entrata: longitude');
            $table->integer('entrance_accuracy')->nullable()->comment('posizione rilevata timbratura entrata: accuratezza in metri');
            $table->timestamp('exit_date')->nullable()->comment('data/ora timbrata uscita');        // data timbrata uscita
            $table->string('exit_ip', 20)->nullable()->comment('indirizzo IP timbratura uscita');
            $table->string('exit_latitude', 64)->nullable()->comment('posizione rilevata timbratura entrata: latitude');
            $table->string('exit_longitude', 64)->nullable()->comment('posizione rilevata timbratura entrata: longitude');
            $table->integer('exit_accuracy')->nullable()->comment('posizione rilevata timbratura entrata: accuratezza in metri');
            $table->integer('check')->default(0)->comment('valore di check timbratura. 0: incompleta; 1:completa; -1: errore/anomalia');
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
        Schema::dropIfExists('attendances');
    }
}
