<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSampleAttendancesView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW _sample_attendances_view AS
select results.*, results.duration_m + results.abscence_m as total_m, ((results.duration_m + results.abscence_m) DIV 60) total_h_int, ((results.duration_m + results.abscence_m) DIV 15 * 15) - (60 * ((results.duration_m + results.abscence_m) DIV 60)) total_minutes_int from ( select presenze.*, IFNULL(assenze.abscence_minutes, 0) abscence_m, IFNULL(assenze.abscence_minutes DIV 60, 0) abscence_h_int, IFNULL((assenze.abscence_minutes DIV 15 * 15), 0) - (60 * IFNULL(assenze.abscence_minutes DIV 60, 0)) abscence_minutes_int, IFNULL(assenze.abscence_justification, '') abscence_justification, IFNULL(giustificativi.description, '') abscence_justification_desc from ( select * from ( select IFNULL(att.id, 0) id, calendar.ref_date, w.id worker_id, w.nome, w.cognome, w.codice_fiscale, w.matricola, w.stato worker_status, calendar.day_date, att.entrance_date, att.entrance_ip, att.exit_date, att.exit_ip, IFNULL(att.duration_m, 0) duration_m, IFNULL(att.duration_h, 0) duration_h, IFNULL(att.duration_h_int, 0) duration_h_int, IFNULL(att.residual_m, 0) residual_m, IFNULL((att.residual_m DIV 15 * 15), 0) residual_m_int, IFNULL(att.chk, -1) chk from ( select '01/06/2021' as day_date, '2021-06-01' as ref_date union select '02/06/2021' as day_date, '2021-06-02' as ref_date union select '03/06/2021' as day_date, '2021-06-03' as ref_date ) calendar cross join workers w left outer join export_v_attendances att on att.day_date = calendar.day_date and att.worker_id = w.id ) presenze where 1=1 ) presenze left outer join absences assenze on presenze.worker_id = assenze.worker_id and presenze.ref_date = assenze.ref_date left outer join giustificativi on assenze.abscence_justification = giustificativi.code ) results order by ref_date, nome, cognome
        ");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('_sample_attendances_view');
    }
}
