<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVVeichlesCounterView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW v_veichles_counter AS
            select * FROM
                (
                    select count(*) inuse from veichles
                    where
                        deleted_at is null and enabled=1 and status = 1
                ) presenti
                cross join
                (
                    select count(*) notinuse from veichles
                    where
                        deleted_at is null and enabled=1 and status < 1
                ) assenti
                cross join
                (
                    select count(*) total from veichles
                    where
                        deleted_at is null and enabled=1
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
        Schema::dropIfExists('v_veichles_counter');
    }
}
