<?php
/*
NOTA:   questa è la vecchia versione della view "export_v_attendances"
        modificata in data 07/09/2021 per aggiungere il supporto alle pause di lavoro
        (doppia timbrata giornaliera)

        Per la nuova versione della view si veda migration
        2021_09_07_125720_edit_export_v_attendances_view.php
*/
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExportVAttendancesView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW export_v_attendances AS
            SELECT
                att.id,
                att.created_at ref_date,
                att.worker worker_id,
                w.nome,
                w.cognome,
                w.codice_fiscale,
                w.matricola,
                w.stato worker_status,
                date_format(DATE(att.created_at), '%d/%m/%Y') day_date,
                date_format(att.entrance_date, '%d/%m/%Y %T') entrance_date,
                att.entrance_ip,
                date_format(att.exit_date, '%d/%m/%Y %T') exit_date,
                att.exit_ip,
                timestampdiff(MINUTE, att.entrance_date, att.exit_date) duration_m,
                round((timestampdiff(MINUTE, att.entrance_date, att.exit_date) / 60), 2) duration_h,
                (timestampdiff(MINUTE, att.entrance_date, att.exit_date) DIV 60) AS duration_h_int,
	            (timestampdiff(MINUTE, att.entrance_date, att.exit_date)) - ((timestampdiff(MINUTE, att.entrance_date, att.exit_date) DIV 60) * 60) as residual_m,
                att.check chk
            FROM
                attendances att
                INNER JOIN workers w ON att.worker = w.id
            WHERE
                att.deleted_at is null
            ORDER BY
                day_date,
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
        Schema::dropIfExists('export_v_attendances');
    }
}
