<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVReportPresenzeView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW report_v_presenze AS
            select
                att.id AS id,
                att.worker AS worker_id,
                w.nome AS nome,
                w.cognome AS cognome,
                w.codice_fiscale AS codice_fiscale,
                w.matricola AS matricola,
                cast(att.created_at AS date) AS day_date,
                att.entrance_date AS entrance_date,
                att.entrance_ip AS entrance_ip,
                att.exit_date AS exit_date,
                att.exit_ip AS exit_ip,
                att.check AS chk,
                timestampdiff(MINUTE, att.entrance_date, att.exit_date) AS duration_m,
                (timestampdiff(MINUTE, att.entrance_date, att.exit_date) / 60) AS duration_h,
                (timestampdiff(MINUTE, att.entrance_date, att.exit_date) DIV 60) AS duration_h_int,
                (timestampdiff(MINUTE, att.entrance_date, att.exit_date)) - ((timestampdiff(MINUTE, att.entrance_date, att.exit_date) DIV 60) * 60) as resitual_m
            from (mgn_service.attendances att
                join mgn_service.workers w on ((att.worker = w.id)))
            order by
                cast(att.created_at AS date),
                att.worker
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('report_v_presenze');
    }
}
