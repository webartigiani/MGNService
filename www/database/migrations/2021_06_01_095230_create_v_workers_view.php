<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVWorkersView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   // exports active workers
        DB::statement("CREATE VIEW v_workers AS
            select * from workers
            where
                deleted_at is NULL
                and data_cessazione is null
            ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('v_workers');
    }
}
