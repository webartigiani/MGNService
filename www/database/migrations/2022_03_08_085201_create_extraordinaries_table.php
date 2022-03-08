<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExtraordinariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extraordinaries', function (Blueprint $table) {
            $table->id();
            $table->integer('worker_id')->default(0)->comment('id dipendente. workers.id');
            $table->date('ref_date')->comment('data straordinario');
            $table->integer('extraordinary_minutes')->comment('numero minuti di straordinario nella data specificata (arrotondati a 15 min.)');
            $table->string('extraordinary_justification', 2)->comment('codice giustificativo straordinario. giustificativi.code');
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
        Schema::dropIfExists('extraordinaries');
    }
}
