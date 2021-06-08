<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkersNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workers_notes', function (Blueprint $table) {
            $table->id();
            $table->integer('worker_id')->default(0)->comment('id dipendente. workers.id');
            $table->date('ref_date')->nullable()->comment('data di riferimento');
            $table->string('notes', 512)->comment('note');
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
        Schema::dropIfExists('workers_notes');
    }
}
