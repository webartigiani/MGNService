<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVWorkersCounterView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW v_workers_counter AS

            select * FROM
                (
                    select count(*) atwork from workers
                    where
                        deleted_at is null and data_cessazione is null and stato = 1
                ) presenti
                cross join
                (
                    select count(*) notatwork from workers
                    where
                        deleted_at is null and data_cessazione is null and stato < 1
                ) assenti
                cross join
                (
                    select count(*) total from workers
                    where
                        deleted_at is null and data_cessazione is null
                ) assunti
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('v_workers_counter');
    }
}
