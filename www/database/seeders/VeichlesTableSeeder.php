<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class VeichlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('verichles')->where('licence_plate', 'XX123XX')->delete();
        DB::table('verichles')->where('licence_plate', 'YY000YY')->delete();

        DB::table('verichles')->insert([
            'manufacter' => 'Citroen',
            'model' => 'Demo',
            'licence_plate' => 'XX123XX',
            "created_at" =>  \Carbon\Carbon::now(), # new \Datetime()
            "updated_at" => \Carbon\Carbon::now(),  # new \Datetime()
        ]);
        DB::table('verichles')->insert([
            'manufacter' => 'Fiat',
            'model' => 'Demo',
            'licence_plate' => 'YY000YY',
            "created_at" =>  \Carbon\Carbon::now(), # new \Datetime()
            "updated_at" => \Carbon\Carbon::now(),  # new \Datetime()
        ]);
    }
}
