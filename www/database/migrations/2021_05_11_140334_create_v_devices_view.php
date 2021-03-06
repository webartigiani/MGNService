<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVDevicesView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   // creates DB view v_devices
        DB::statement("CREATE VIEW v_devices AS
            select d.id, d.platform, d.`version`, d.manufacter, d.model, d.is_virtual, d.is_online, d.connection_type, d.enabled, d.status, d.status_date, d.uuid, d.serial, d.created_at, d.updated_at, d.app_version from devices d
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW v_devices");
    }
}
