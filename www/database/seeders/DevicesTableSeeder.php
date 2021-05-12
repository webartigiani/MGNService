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
            'serial' => '20c8bef9-3f86-4ddc-a8c6-c496428a05b7',
            'uuid' => 'aae5ba8eed5a',
            "created_at" =>  \Carbon\Carbon::now(), # new \Datetime()
            "updated_at" => \Carbon\Carbon::now(),  # new \Datetime()
        ]);
        DB::table('devices')->insert([
            'platform' => 'Android',
            'version' => '6.1.0',
            'manufacter' => 'HomTom',
            'model' => 'HT16',
            'is_virtual' =>  false,
            'serial' => 'a2799c9f-1895-4135-bca0-bcdfb46a3c02',
            'uuid' => '12c11323',
            "created_at" =>  \Carbon\Carbon::now(), # new \Datetime()
            "updated_at" => \Carbon\Carbon::now(),  # new \Datetime()
        ]);
    }
}
