<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkingDaysCalendarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('working_days_calendar', function (Blueprint $table) {
            $table->integer('worker_id')->default(0)->comment('id dipendente, cui si riferisce il calendario (workers.id) o 0 per calendario generale');
            $table->integer('day_of_week')->default(2)->comment('giorno della settimana (sunday=1)');
            $table->integer('working_hours')->default(0)->comment('numero ore lavorative nel giorno');
            $table->timestamps();
            $table->primary(array('worker_id', 'day_of_week'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('working_days_calendar');
    }
}
