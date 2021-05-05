<?php

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
            $table->string('manufacter', 128);
            $table->string('model', 128);
            $table->string('licence_plate', 10)->unique();
            $table->integer('status')->default(0);
            $table->boolean('enabled')->default(true);
            $table->integer('device')->nullable();
            $table->integer('worker')->nullable();
            $table->timestamps();
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
