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
                att.id, att.worker worker_id,
                w.nome, w.cognome, w.codice_fiscale, w.matricola,
                DATE(att.created_at) day_date,
                att.entrance_date, att.entrance_ip,
                att.exit_date, att.exit_ip,
                att.check chk,

                TIMESTAMPDIFF(MINUTE, att.entrance_date, att.exit_date) duration_m,
                (TIMESTAMPDIFF(MINUTE, att.entrance_date, att.exit_date) / 60) duration_h,
                round(TIMESTAMPDIFF(MINUTE, att.entrance_date, att.exit_date) / 60) duration_h_int
            from attendances att
            inner join workers w
                on att.worker = w.id
            order by day_date, att.worker
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
