<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTimbratureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timbrature', function (Blueprint $table) {
            $table->id();
            $table->integer('dipendente')->default(0)->comment('id dipendente. workers.id');
            $table->string('tipo', 1)->default('E')->comment('tipo timbratura. E=entrata; U=uscita');               // tipo timbratura
            $table->integer('modo')->default(0)->comment('modo timbratura. 1=tramite APP su veicolo; 2=tramite tablet da portale');
            $table->timestamp('data_ora')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('data/ora timbrata');     // data timbrata
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
        Schema::dropIfExists('timbrature');
    }
}
