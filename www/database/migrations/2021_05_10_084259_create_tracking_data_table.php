<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrackingDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracking_data', function (Blueprint $table) {
            $table->id();
            $table->string('session_id', 20)->comment('id sessione tracciamento GPS: tracking_sessions.session_id');
            $table->string('latitude', 64)->nullable()->comment('ultima posizione rilevata: latitude');
            $table->string('longitude', 64)->nullable()->comment('ultima posizione rilevata: longitude');
            $table->integer('accuracy')->nullable()->comment('ultime posizione rilevata: accuratezza in metri');
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
        Schema::dropIfExists('tracking_data');
    }
}
