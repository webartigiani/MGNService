<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absences', function (Blueprint $table) {
            $table->id();
            $table->integer('worker_id')->default(0)->comment('id dipendente. workers.id');
            $table->date('ref_date')->comment('data assenza');
            $table->integer('abscence_minutes')->comment('numero minuti di assenza nella data specificata (arrotondati a 15 min.)');
            $table->string('abscence_justification', 2)->comment('codice giustificativo. giustificativi.code');
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
        Schema::dropIfExists('absences');
    }
}
