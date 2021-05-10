<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DevicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('devices')->truncate();

        DB::table('devices')->insert([
            'platform' => 'Android',
            'version' => '9.0.0',
            'manufacter' => 'Dogee',
            'model' => 'N20',
            'is_virtual' =>  false,
            'serial' => '123',
            'uuid' => '123',
            "created_at" =>  \Carbon\Carbon::now(), # new \Datetime()
            "updated_at" => \Carbon\Carbon::now(),  # new \Datetime()
        ]);
    }
}
