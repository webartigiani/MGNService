<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->where('email', 'info@webartigiani.it')->delete();
        DB::table('users')->where('email', 'info@mgnservice.it')->delete();

        DB::table('users')->insert([
            'name' => 'WebArtigiani',
            'email' => 'info@webartigiani.it',
            'password' => bcrypt('cammello-zoccolo-82'),
            'type' => 'webmaster',
            "created_at" =>  \Carbon\Carbon::now(), # new \Datetime()
            "updated_at" => \Carbon\Carbon::now(),  # new \Datetime()
        ]);
        DB::table('users')->insert([
            'name' => 'Staff MGN',
            'email' => 'info@mgnservice.it',
            'password' => bcrypt('123456'),
            'type' => 'admin',
            "created_at" =>  \Carbon\Carbon::now(), # new \Datetime()
            "updated_at" => \Carbon\Carbon::now(),  # new \Datetime()
        ]);
    }
}
