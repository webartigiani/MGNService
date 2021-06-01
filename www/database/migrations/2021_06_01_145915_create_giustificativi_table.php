<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGiustificativiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('giustificativi', function (Blueprint $table) {
            $table->string('code', 2)->comment('codice giustificativo. es: AI');
            $table->string('description', 128)->comment('descrizione giustificativo');
            $table->string('item', 128)->nullable()->comment('codice voce generazione diretta su cedolino (non usato)');
            $table->string('ref_code', 2)->comment('codice giustificativo di riferimento. es: AI (non usato)');
            $table->string('inclusion', 2)->comment('inclusione inquadratura giorno (non usato)');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('giustificativi');
    }
}
