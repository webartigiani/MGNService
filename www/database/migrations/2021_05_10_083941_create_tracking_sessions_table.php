<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTrackingSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracking_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('session_id', 20)->default('')->comment('id sessione tracciamento GPS');
            $table->timestamp('start_date_time')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('data/ora inizio sessione tracciamento');
            $table->timestamp('end_date_time')->nullable()->comment('data/ora fine sessione tracciamenton GPS');
            $table->integer('device')->nullable()->comment('device attualmente in uso: devices.id');
            $table->integer('worker')->nullable()->comment('dipendente a bordo. workers.id');
            $table->integer('veichle')->default(0)->comment('id veicolo: veichles.id');
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
        Schema::dropIfExists('tracking_sessions');
    }
}
