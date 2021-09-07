<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditExportVAttendancesView extends Migration
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
                att.id AS id,
                att.created_at AS ref_date,

                /* worker data */
                att.worker AS worker_id,
                w.nome AS nome,
                w.cognome AS cognome,
                w.codice_fiscale AS codice_fiscale,
                w.matricola AS matricola,
                w.stato AS worker_status,

                /* current/calendar date */
                date_format(cast(att.created_at AS date), '%d/%m/%Y') AS day_date,

                /* 1st timbrata */
                date_format(att.entrance_date, '%d/%m/%Y %T') AS entrance_date,
                att.entrance_ip AS entrance_ip,
                date_format(att.exit_date, '%d/%m/%Y %T') AS exit_date,
                att.exit_ip AS exit_ip,

                /* 2nd timbrata */
                date_format(att.entrance_date_2, '%d/%m/%Y %T') AS entrance_date_2,
                att.entrance_ip_2 AS entrance_ip_2,
                date_format(att.exit_date_2, '%d/%m/%Y %T') AS exit_date_2,
                att.exit_ip_2 AS exit_ip_2,

                /* total minutes worked, considering 1st and 2nd timbrata (2nd can be null) */
                timestampdiff(MINUTE, att.entrance_date, att.exit_date) +
                IFNULL(timestampdiff(MINUTE, att.entrance_date_2, att.exit_date_2), 0) AS duration_m,

                /* hours worked (float and int), considering 1st and 2nd timbrata (2nd can be null) */
                round((
                    timestampdiff(MINUTE, att.entrance_date, att.exit_date) / 60)
                    + IFNULL(timestampdiff(MINUTE, att.entrance_date_2, att.exit_date_2) / 60, 0)
                , 2) AS duration_h,
                ((
                    timestampdiff(MINUTE, att.entrance_date, att.exit_date)
                    + IFNULL(timestampdiff(MINUTE, att.entrance_date_2, att.exit_date_2), 0)
                ) DIV 60) AS duration_h_int,

                /*
                    residual worked minutes, considering 1st and 2nd timbrata (2nd can be null)
                    Before code:
                        (timestampdiff(MINUTE, att.entrance_date, att.exit_date)
                        - ((timestampdiff(MINUTE, att.entrance_date, att.exit_date) DIV 60) * 60)) AS residual_m,
                */
                ((timestampdiff(MINUTE, att.entrance_date, att.exit_date)
                    + IFNULL(timestampdiff(MINUTE, att.entrance_date_2, att.exit_date_2), 0))
                - (((timestampdiff(MINUTE, att.entrance_date, att.exit_date)
                    + IFNULL(timestampdiff(MINUTE, att.entrance_date_2, att.exit_date_2), 0))
                DIV 60) * 60)) AS residual_m,

                /* check timbrata */
                att.check AS chk

            FROM (attendances att
                JOIN workers w ON ((att.worker = w.id)))
            WHERE (att.deleted_at IS NULL)
            ORDER BY
                date_format(cast(att.created_at AS date), '%d/%m/%Y'),
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
        //
    }
}
