<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppVWorkersView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   // creates DB view app_v_workers
        // lists workers for APP
        DB::statement("CREATE VIEW app_v_workers AS
            select id, nome name, cognome surname from workers
            where
                modo_timbratura <= 1
                and deleted_at is null
                and data_cessazione is null
                order by nome, cognome
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW app_v_workers");
    }
}
