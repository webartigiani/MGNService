<?php

use Egulias\EmailValidator\Warning\Comment;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVerichlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verichles', function (Blueprint $table) {
            $table->id();
            $table->string('manufacter', 128)->comment('marca veicolo');
            $table->string('model', 128)->comment('modello veicolo');
            $table->string('licence_plate', 10)->unique()->comment('numero di targa (unique)');
            $table->integer('status')->default(0)->comment('stato del veicolo. 0=in sede; 1=fuori sede');
            $table->timestamp('status_date')->nullable()->comment('data/ora ultima modifica stato');
            $table->integer('device')->nullable()->comment('device attualmente in uso: devices.id');
            $table->integer('worker')->nullable()->comment('dipendente a bordo. workers.id');
            $table->boolean('enabled')->default(true)->comment('abilitato/disabilitato da Admin');
            $table->string('tracking_session', 20)->default('')->comment('id sessione geo-localizzazione. geo_tracking.session_id');
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
        Schema::dropIfExists('verichles');
    }
}
