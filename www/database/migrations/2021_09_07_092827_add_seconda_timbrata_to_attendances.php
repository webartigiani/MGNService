<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSecondaTimbrataToAttendances extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->timestamp('entrance_date_2')->after('exit_accuracy')->nullable()->comment('data/ora timbrata entrata n.2, se attivo workers.pausa_orario');
            $table->string('entrance_ip_2', 20)->after('entrance_date_2')->nullable()->default('')->comment('indirizzo IP timbratura entrata n.2, se attivo workers.pausa_orario');
            $table->string('entrance_latitude_2', 64)->after('entrance_ip_2')->nullable()->comment('posizione rilevata timbratura entrata n.2: latitude, se attivo workers.pausa_orario');
            $table->string('entrance_longitude_2', 64)->after('entrance_latitude_2')->nullable()->comment('posizione rilevata timbratura entrata n.2: longitude, se attivo workers.pausa_orario');
            $table->integer('entrance_accuracy_2')->after('entrance_longitude_2')->nullable()->comment('posizione rilevata timbratura entrata n.2: accuratezza in metri, se attivo workers.pausa_orario');
            $table->timestamp('exit_date_2')->after('entrance_accuracy_2')->nullable()->comment('data/ora timbrata uscita n.2, se attivo workers.pausa_orario');
            $table->string('exit_ip_2', 20)->after('exit_date_2')->nullable()->comment('indirizzo IP timbratura uscita n.2, se attivo workers.pausa_orario');
            $table->string('exit_latitude_2', 64)->after('exit_ip_2')->nullable()->comment('posizione rilevata timbratura entrata n.2: latitude, se attivo workers.pausa_orario');
            $table->string('exit_longitude_2', 64)->after('exit_latitude_2')->nullable()->comment('posizione rilevata timbratura entrata n.2: longitude, se attivo workers.pausa_orario');
            $table->integer('exit_accuracy_2')->after('exit_longitude_2')->nullable()->comment('posizione rilevata timbratura entrata n.2: accuratezza in metri, se attivo workers.pausa_orario');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attendances', function (Blueprint $table) {
            //
        });
    }
}
