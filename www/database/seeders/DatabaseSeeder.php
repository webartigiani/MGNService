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
        // \App\Models\User::factory(10)->create();
        $this->call(CategoriesTableSeeder::class);
        $this->call(TagsTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        //duplicate product for data
        $this->call(ProductsTableSeeder::class);

        $this->call(UsersTableSeeder::class);                   // adds 2 users: webmaster, admin
        $this->call(WorkersTableSeeder::class);                 // adds 25 workers (from Excel)
        $this->call(VeichlesTableSeeder::class);                // adds 2 demo veichles
    }
}
