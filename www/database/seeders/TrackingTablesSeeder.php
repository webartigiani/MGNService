<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TrackingTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tracking_sessions')->delete();
        DB::table('tracking_data')->delete();

        $sessionID = '20210510080000-1';
        $gps = [];

        DB::table('tracking_sessions')->insert([
            'session_id' => $sessionID,
            'start_date_time' => \Carbon\Carbon::now(),
            'device' => 1,
            'worker' => 1,
            "veichle" =>  1,
            "created_at" => \Carbon\Carbon::now(),  # new \Datetime()
            "updated_at" => \Carbon\Carbon::now()  # new \Datetime()
        ]);

        $gps = explode(',', '44.63002610819176, 10.898761096541586');
        DB::table('tracking_data')->insert([
            'session_id' => $sessionID,
            'latitude' => trim($gps[0]),
            'longitude' => trim($gps[1]),
            'accuracy' => 10,
            "created_at" => \Carbon\Carbon::now(),  # new \Datetime()
            "updated_at" => \Carbon\Carbon::now()  # new \Datetime()
        ]);
        $gps = explode(',', '44.631296413785286, 10.899925236101957');
        DB::table('tracking_data')->insert([
            'session_id' => $sessionID,
            'latitude' => trim($gps[0]),
            'longitude' => trim($gps[1]),
            'accuracy' => 10,
            "created_at" => \Carbon\Carbon::now(),  # new \Datetime()
            "updated_at" => \Carbon\Carbon::now()  # new \Datetime()
        ]);
        $gps = explode(',', '44.63186251927835, 10.90050730588214');
        DB::table('tracking_data')->insert([
            'session_id' => $sessionID,
            'latitude' => trim($gps[0]),
            'longitude' => trim($gps[1]),
            'accuracy' => 10,
            "created_at" => \Carbon\Carbon::now(),  # new \Datetime()
            "updated_at" => \Carbon\Carbon::now()  # new \Datetime()
        ]);
        $gps = explode(',', '44.63191774878691, 10.90050730588214');
        DB::table('tracking_data')->insert([
            'session_id' => $sessionID,
            'latitude' => trim($gps[0]),
            'longitude' => trim($gps[1]),
            'accuracy' => 10,
            "created_at" => \Carbon\Carbon::now(),  # new \Datetime()
            "updated_at" => \Carbon\Carbon::now()  # new \Datetime()
        ]);
        $gps = explode(',', '44.63186251927835, 10.900546110534155');
        DB::table('tracking_data')->insert([
            'session_id' => $sessionID,
            'latitude' => trim($gps[0]),
            'longitude' => trim($gps[1]),
            'accuracy' => 10,
            "created_at" => \Carbon\Carbon::now(),  # new \Datetime()
            "updated_at" => \Carbon\Carbon::now()  # new \Datetime()
        ]);
        $gps = explode(',', '44.6327737994488, 10.901283398922388');
        DB::table('tracking_data')->insert([
            'session_id' => $sessionID,
            'latitude' => trim($gps[0]),
            'longitude' => trim($gps[1]),
            'accuracy' => 10,
            "created_at" => \Carbon\Carbon::now(),  # new \Datetime()
            "updated_at" => \Carbon\Carbon::now()  # new \Datetime()
        ]);
        $gps = explode(',', '44.633726486145825, 10.902234112896693');
        DB::table('tracking_data')->insert([
            'session_id' => $sessionID,
            'latitude' => trim($gps[0]),
            'longitude' => trim($gps[1]),
            'accuracy' => 10,
            "created_at" => \Carbon\Carbon::now(),  # new \Datetime()
            "updated_at" => \Carbon\Carbon::now()  # new \Datetime()
        ]);
        $gps = explode(',', '44.63447205613009, 10.902117698940655');
        DB::table('tracking_data')->insert([
            'session_id' => $sessionID,
            'latitude' => trim($gps[0]),
            'longitude' => trim($gps[1]),
            'accuracy' => 10,
            "created_at" => \Carbon\Carbon::now(),  # new \Datetime()
            "updated_at" => \Carbon\Carbon::now()  # new \Datetime()
        ]);
        $gps = explode(',', '44.63473438403166, 10.901011766358302');
        DB::table('tracking_data')->insert([
            'session_id' => $sessionID,
            'latitude' => trim($gps[0]),
            'longitude' => trim($gps[1]),
            'accuracy' => 10,
            "created_at" => \Carbon\Carbon::now(),  # new \Datetime()
            "updated_at" => \Carbon\Carbon::now()  # new \Datetime()
        ]);
        $gps = explode(',', '44.63502432401692, 10.89949838492982');
        DB::table('tracking_data')->insert([
            'session_id' => $sessionID,
            'latitude' => trim($gps[0]),
            'longitude' => trim($gps[1]),
            'accuracy' => 10,
            "created_at" => \Carbon\Carbon::now(),  # new \Datetime()
            "updated_at" => \Carbon\Carbon::now()  # new \Datetime()
        ]);
        $gps = explode(',', '44.63524522970001, 10.898314843043442');
        DB::table('tracking_data')->insert([
            'session_id' => $sessionID,
            'latitude' => trim($gps[0]),
            'longitude' => trim($gps[1]),
            'accuracy' => 10,
            "created_at" => \Carbon\Carbon::now(),  # new \Datetime()
            "updated_at" => \Carbon\Carbon::now()  # new \Datetime()
        ]);
        $gps = explode(',', '44.63565942558927, 10.896471622072857');
        DB::table('tracking_data')->insert([
            'session_id' => $sessionID,
            'latitude' => trim($gps[0]),
            'longitude' => trim($gps[1]),
            'accuracy' => 10,
            "created_at" => \Carbon\Carbon::now(),  # new \Datetime()
            "updated_at" => \Carbon\Carbon::now()  # new \Datetime()
        ]);
        $gps = explode(',', '44.635963167362426, 10.89563732205459');
        DB::table('tracking_data')->insert([
            'session_id' => $sessionID,
            'latitude' => trim($gps[0]),
            'longitude' => trim($gps[1]),
            'accuracy' => 10,
            "created_at" => \Carbon\Carbon::now(),  # new \Datetime()
            "updated_at" => \Carbon\Carbon::now()  # new \Datetime()
        ]);
        $gps = explode(',', '44.63623929486748, 10.894783619710319');
        DB::table('tracking_data')->insert([
            'session_id' => $sessionID,
            'latitude' => trim($gps[0]),
            'longitude' => trim($gps[1]),
            'accuracy' => 10,
            "created_at" => \Carbon\Carbon::now(),  # new \Datetime()
            "updated_at" => \Carbon\Carbon::now()  # new \Datetime()
        ]);
        $gps = explode(',', '44.63626863739, 10.893510969631148');
        DB::table('tracking_data')->insert([
            'session_id' => $sessionID,
            'latitude' => trim($gps[0]),
            'longitude' => trim($gps[1]),
            'accuracy' => 10,
            "created_at" => \Carbon\Carbon::now(),  # new \Datetime()
            "updated_at" => \Carbon\Carbon::now()  # new \Datetime()
        ]);
        $gps = explode(',', '44.63791344704865, 10.894785544684487');
        DB::table('tracking_data')->insert([
            'session_id' => $sessionID,
            'latitude' => trim($gps[0]),
            'longitude' => trim($gps[1]),
            'accuracy' => 10,
            "created_at" => \Carbon\Carbon::now(),  # new \Datetime()
            "updated_at" => \Carbon\Carbon::now()  # new \Datetime()
        ]);
        $gps = explode(',', '44.639588952874, 10.895800884133756');
        DB::table('tracking_data')->insert([
            'session_id' => $sessionID,
            'latitude' => trim($gps[0]),
            'longitude' => trim($gps[1]),
            'accuracy' => 10,
            "created_at" => \Carbon\Carbon::now(),  # new \Datetime()
            "updated_at" => \Carbon\Carbon::now()  # new \Datetime()
        ]);
    }
}
