<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TimbrateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('timbrate')->truncate();

        DB::table('timbrate')->insert([
            'worker' => 1,                          // worker 1, 2021-05-03
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-03 07:59:00'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 1,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-03 18:03:04'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 1,                          // worker 1, 2021-05-04
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-04 07:56:45'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 1,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-04 18:01:03'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 1,                          // worker 1, 2021-05-05
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-05 07:52:38'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 1,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-05 18:06:13'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 1,                          // worker 1, 2021-05-06
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-06 08:00:13'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 1,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-06 18:12:02'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 1,                          // worker 1, 2021-05-07
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-07 07:58:13'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 1,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-07 18:02:02'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 1,                          // worker 1, 2021-05-10
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-10 07:56:13'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 1,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-10 18:01:02'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 1,                          // worker 1, 2021-05-11
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-11 07:55:03'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 1,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-11 18:03:21'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 1,                          // worker 1, 2021-05-12
            'type' => 'E',
            'mode' => 2,
            "date_time" =>  '2021-05-12 07:56:03',
            'veichle' => 1,
            'device' => 1,
            'tracking_session' => '20210510080000-1'
        ]);


        DB::table('timbrate')->insert([
            'worker' => 2,                          // worker 2, 2021-05-03
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-03 07:59:00'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 2,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-03 18:03:04'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 2,                          // worker 2, 2021-05-04
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-04 07:56:45'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 2,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-04 18:01:03'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 2,                          // worker 2, 2021-05-05
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-05 07:52:38'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 2,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-05 18:06:13'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 2,                          // worker 2, 2021-05-06
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-06 08:00:13'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 2,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-06 18:12:02'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 2,                          // worker 2, 2021-05-07
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-07 07:58:13'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 2,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-07 18:02:02'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 2,                          // worker 2, 2021-05-10
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-10 07:56:13'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 2,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-10 18:01:02'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 2,                          // worker 2, 2021-05-11
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-11 07:55:03'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 2,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-11 18:03:21'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 2,                          // worker 2, 2021-05-12
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-12 07:56:03'
        ]);


        DB::table('timbrate')->insert([
            'worker' => 3,                          // worker 3, 2021-05-03
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-03 07:59:00'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 3,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-03 18:03:04'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 3,                          // worker 3, 2021-05-04
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-04 07:56:45'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 3,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-04 18:01:03'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 3,                          // worker 3, 2021-05-05
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-05 07:52:38'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 3,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-05 18:06:13'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 3,                          // worker 3, 2021-05-06
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-06 08:00:13'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 3,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-06 18:12:02'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 3,                          // worker 3, 2021-05-07
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-07 07:58:13'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 3,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-07 18:02:02'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 3,                          // worker 3, 2021-05-10
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-10 07:56:13'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 3,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-10 18:01:02'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 3,                          // worker 3, 2021-05-11
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-11 07:55:03'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 3,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-11 18:03:21'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 3,                          // worker 3, 2021-05-12
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-12 07:56:03'
        ]);

        DB::table('timbrate')->insert([
            'worker' => 4,                          // worker 4, 2021-05-03
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-03 07:59:00'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 4,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-03 18:03:04'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 4,                          // worker 4, 2021-05-04
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-04 07:56:45'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 4,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-04 18:01:03'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 4,                          // worker 4, 2021-05-05
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-05 07:52:38'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 4,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-05 18:06:13'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 4,                          // worker 4, 2021-05-06
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-06 08:00:13'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 4,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-06 18:12:02'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 4,                          // worker 4, 2021-05-07
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-07 07:58:13'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 4,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-07 18:02:02'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 4,                          // worker 4, 2021-05-10
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-10 07:56:13'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 4,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-10 18:01:02'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 4,                          // worker 4, 2021-05-11
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-11 07:55:03'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 4,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-11 18:03:21'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 4,                          // worker 4, 2021-05-12
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-12 07:56:03'
        ]);


        DB::table('timbrate')->insert([
            'worker' => 5,                          // worker 5, 2021-05-03
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-03 07:59:00'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 5,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-03 18:03:04'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 5,                          // worker 5, 2021-05-04
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-04 07:56:45'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 5,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-04 18:01:03'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 5,                          // worker 5, 2021-05-05
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-05 07:52:38'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 5,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-05 18:06:13'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 5,                          // worker 5, 2021-05-06
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-06 08:00:13'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 5,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-06 18:12:02'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 5,                          // worker 5, 2021-05-07
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-07 07:58:13'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 5,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-07 18:02:02'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 5,                          // worker 5, 2021-05-10
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-10 07:56:13'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 5,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-10 18:01:02'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 5,                          // worker 5, 2021-05-11
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-11 07:55:03'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 5,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-11 18:03:21'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 5,                          // worker 5, 2021-05-12
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-12 07:56:03'
        ]);


        DB::table('timbrate')->insert([
            'worker' => 6,                          // worker 6, 2021-05-03
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-03 07:59:00'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 6,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-03 18:03:04'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 6,                          // worker 6, 2021-05-04
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-04 07:56:45'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 6,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-04 18:01:03'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 6,                          // worker 6, 2021-05-05
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-05 07:52:38'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 6,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-05 18:06:13'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 6,                          // worker 6, 2021-05-06
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-06 08:00:13'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 6,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-06 18:12:02'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 6,                          // worker 6, 2021-05-07
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-07 07:58:13'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 6,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-07 18:02:02'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 6,                          // worker 6, 2021-05-10
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-10 07:56:13'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 6,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-10 18:01:02'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 6,                          // worker 6, 2021-05-11
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-11 07:55:03'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 6,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-11 18:03:21'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 6,                          // worker 6, 2021-05-12
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-12 07:56:03'
        ]);


        DB::table('timbrate')->insert([
            'worker' => 7,                          // worker 7, 2021-05-03
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-03 07:59:00'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 7,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-03 18:03:04'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 7,                          // worker 7, 2021-05-04
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-04 07:56:45'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 7,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-04 18:01:03'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 7,                          // worker 7, 2021-05-05
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-05 07:52:38'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 7,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-05 18:06:13'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 7,                          // worker 7, 2021-05-06
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-06 08:00:13'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 7,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-06 18:12:02'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 7,                          // worker 7, 2021-05-07
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-07 07:58:13'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 7,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-07 18:02:02'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 7,                          // worker 7, 2021-05-10
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-10 07:56:13'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 7,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-10 18:01:02'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 7,                          // worker 7, 2021-05-11
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-11 07:55:03'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 7,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-11 18:03:21'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 7,                          // worker 7, 2021-05-12
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-12 07:56:03'
        ]);


        DB::table('timbrate')->insert([
            'worker' => 8,                          // worker 8, 2021-05-03
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-03 07:59:00'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 8,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-03 18:03:04'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 8,                          // worker 8, 2021-05-04
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-04 07:56:45'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 8,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-04 18:01:03'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 8,                          // worker 8, 2021-05-05
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-05 07:52:38'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 8,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-05 18:06:13'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 8,                          // worker 8, 2021-05-06
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-06 08:00:13'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 8,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-06 18:12:02'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 8,                          // worker 8, 2021-05-07
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-07 07:58:13'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 8,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-07 18:02:02'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 8,                          // worker 8, 2021-05-10
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-10 07:56:13'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 8,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-10 18:01:02'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 8,                          // worker 8, 2021-05-11
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-11 07:55:03'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 8,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-11 18:03:21'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 8,                          // worker 8, 2021-05-12
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-12 07:56:03'
        ]);

        DB::table('timbrate')->insert([
            'worker' => 9,                          // worker 9,, 2021-05-03
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-03 07:59:00'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 9,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-03 18:03:04'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 9,                          // worker 9,, 2021-05-04
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-04 07:56:45'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 9,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-04 18:01:03'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 9,                          // worker 9,, 2021-05-05
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-05 07:52:38'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 9,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-05 18:06:13'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 9,                          // worker 9,, 2021-05-06
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-06 08:00:13'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 9,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-06 18:12:02'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 9,                          // worker 9,, 2021-05-07
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-07 07:58:13'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 9,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-07 18:02:02'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 9,                          // worker 9,, 2021-05-10
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-10 07:56:13'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 9,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-10 18:01:02'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 9,                          // worker 9,, 2021-05-11
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-11 07:55:03'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 9,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-11 18:03:21'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 9,                          // worker 9,, 2021-05-12
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-12 07:56:03'
        ]);


        DB::table('timbrate')->insert([
            'worker' => 10,                          // worker 10, 2021-05-03
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-03 07:59:00'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 10,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-03 18:03:04'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 10,                          // worker 10, 2021-05-04
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-04 07:56:45'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 10,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-04 18:01:03'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 10,                          // worker 10, 2021-05-05
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-05 07:52:38'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 10,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-05 18:06:13'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 10,                          // worker 10, 2021-05-06
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-06 08:00:13'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 10,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-06 18:12:02'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 10,                          // worker 10, 2021-05-07
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-07 07:58:13'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 10,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-07 18:02:02'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 10,                          // worker 10, 2021-05-10
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-10 07:56:13'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 10,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-10 18:01:02'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 10,                          // worker 10, 2021-05-11
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-11 07:55:03'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 10,
            'type' => 'U',
            'mode' => 1,
            "date_time" =>  '2021-05-11 18:03:21'
        ]);
        DB::table('timbrate')->insert([
            'worker' => 10,                          // worker 10, 2021-05-12
            'type' => 'E',
            'mode' => 1,
            "date_time" =>  '2021-05-12 07:56:03'
        ]);
    }
}
