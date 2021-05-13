<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppVVeichlesView extends Migration
{
        /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   // creates DB view app_v_veichles
        // lists veichles for APP
        DB::statement("CREATE VIEW app_v_veichles AS

            select id, manufacter, model, licence_plate from veichles
            where
                status = 0
                and  enabled = true
                and deleted_at is null
            order by licence_plate
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW app_v_veichles");
    }
}
