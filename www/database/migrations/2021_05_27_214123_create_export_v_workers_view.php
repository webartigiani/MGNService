<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExportVWorkersView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE VIEW export_v_workers AS
                select
                    codice_azienda, denominazione_azienda, id dipendente, cognome, nome, codice_fiscale,
                    DATE_FORMAT(data_assunzione, "%d/%m/%Y") data_assunzione ,
                    DATE_FORMAT(data_cessazione, "%d/%m/%Y") data_cessazione
                from workers
                where deleted_at is null
                order by id
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('export_v_workers');
    }
}
