<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableGiustificativi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('giustificativi', function (Blueprint $table) {
            $table->string('used_for', 64)->after('inclusion')->nullable()->comment('uso giustificativo: ABS=assenza; STR=straordinario; NULL/EMPTY=non usato');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
