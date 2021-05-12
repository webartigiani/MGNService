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
        DB::table('veichles')->truncate();

        DB::table('veichles')->insert([
            'manufacter' => 'Citroen',
            'model' => 'C3',
            'licence_plate' => 'XX123XX',
            "created_at" =>  \Carbon\Carbon::now(), # new \Datetime()
            "updated_at" => \Carbon\Carbon::now(),  # new \Datetime()
        ]);
        DB::table('veichles')->insert([
            'manufacter' => 'Fiat',
            'model' => 'Punto',
            'licence_plate' => 'YY000YY',
            "created_at" =>  \Carbon\Carbon::now(), # new \Datetime()
            "updated_at" => \Carbon\Carbon::now(),  # new \Datetime()
        ]);
    }
}
