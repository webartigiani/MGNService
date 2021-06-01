<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);                   // adds 2 users: webmaster, admin
        $this->call(WorkersTableSeeder::class);                 // adds 25 workers (from Excel)
        $this->call(GiustificativiTableSeeder::class);          // adds 128 giustificativi (from Excel)

        /**
         * DEMO DATA
         */
        /*
        $this->call(VeichlesTableSeeder::class);                // adds 2 demo veichles
        $this->call(DevicesTableSeeder::class);                 // adds 1 demo device
        $this->call(TrackingTablesSeeder::class);               // adds 1 tracking session and its data
        */
    }
}
