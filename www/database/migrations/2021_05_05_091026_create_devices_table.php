<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('platform', 128);
            $table->string('version', 10);
            $table->string('manufacter', 128);
            $table->string('model', 128);
            $table->boolean('is_virtual')->default(false);
            $table->string('serial', 128);
            $table->string('uuid', 128);
            $table->boolean('is_online')->default(false);
            $table->boolean('enabled')->default(true);
            $table->string('latitude', 64)->nullable();
            $table->string('longitude', 64)->nullable();
            $table->integer('accuracy')->nullable();
            $table->timestamp('last_position')->nullable();
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
        Schema::dropIfExists('devices_');
    }
}
