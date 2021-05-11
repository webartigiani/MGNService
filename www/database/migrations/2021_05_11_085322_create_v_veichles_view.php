<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVVeichlesView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   // creates DB view v_timbrate
        DB::statement("CREATE VIEW v_veichles AS
                    select
                        v.id, v.manufacter, v.model, v.licence_plate, v.enabled, v.status, v.created_at, v.updated_at,
                        v.worker worker_id, CONCAT(w.nome, ' ' , w.cognome) as worker_nome_cognome,
                        v.device device_id, CONCAT(d.manufacter, ' ' , d.model) device_model, lower(`d`.`platform`) AS `device_os`,
                        v.tracking_session, t.start_date_time tracking_session_start
                        from veichles v
                        left outer join workers w
                            on v.worker = w.id
                        left outer join devices d
                            on v.device = d.id
                        left outer join tracking_sessions t
                            on v.tracking_session = t.session_id
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW v_veichles");
    }
}
