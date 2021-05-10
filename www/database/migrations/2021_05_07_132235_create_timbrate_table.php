<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTimbrateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timbrate', function (Blueprint $table) {
            $table->id();
            $table->integer('worker')->default(0)->comment('id dipendente. workers.id');
            $table->string('type', 1)->default('E')->comment('tipo timbratura. E=entrata; U=uscita');               // tipo timbratura
            $table->integer('mode')->default(0)->comment('modo timbratura. 1=tramite APP su veicolo; 2=tramite tablet da portale');
            $table->timestamp('date_time')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('data/ora timbrata');     // data timbrata
            $table->integer('veichle')->default(0)->comment('id veicolo, se con veicolo. veichles.id');
            $table->integer('device')->default(0)->comment('id dispositivo. devices.id');
            $table->string('tracking_session', 20)->default('')->comment('id sessione geo-localizzazione. geo_tracking.session_id');
            $table->string('latitude', 64)->nullable()->comment('posizione rilevata: latitude');
            $table->string('longitude', 64)->nullable()->comment('posizione rilevata: longitude');
            $table->integer('accuracy')->nullable()->comment('posizione rilevata: accuratezza in metri');
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
