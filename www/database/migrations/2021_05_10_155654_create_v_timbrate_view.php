<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateVTimbrateView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   // creates DB view v_timbrate
        DB::statement("CREATE VIEW v_timbrate AS
            select
                `timb`.`id` AS `id`,`timb`.`date_time` AS `date_time`,
                `w`.`id` AS `worker_id`, concat(`w`.`nome`,' ',`w`.`cognome`) AS `worker_nome_cognome`,
                `timb`.`type` AS `type`,`timb`.`mode` AS `mode`,`timb`.`tracking_session` AS `tracking_session_id`,
                `timb`.`veichle` AS `veichle_id`, concat(`v`.`manufacter`,' ',`v`.`model`) AS `veichle_model`,`v`.`licence_plate` AS `veichle_targa`,
                `timb`.`device` AS `device_id`, concat(`d`.`manufacter`,' ',`d`.`model`) AS `device_model`,lower(`d`.`platform`) AS `device_os`
                from
                (((`timbrate` `timb` join `workers` `w` on((`timb`.`worker` = `w`.`id`)))
                left join `devices` `d` on((`timb`.`device` = `d`.`id`)))
                left join `veichles` `v` on((`timb`.`veichle` = `v`.`id`)))
                order by `timb`.`date_time` desc
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW v_timbrate");
    }
}
