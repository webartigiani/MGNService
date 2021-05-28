<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Http\Controllers\UtilsController;
use DateTime;
use DateTimeZone;
use DateInterval;

class AttendancesTableSeeder extends Seeder
{
    private $utils;

// #region Contructor
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UtilsController $utils)
    {
        $this->utils = $utils;
    }
// #endregion Contructor

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Inserts random attendances for all workers
         * from 2020-01-01 to 2021-05-31
         */
        DB::table('attendances')->truncate();           // truncates previous attendances

        $s = new DateTime('2021-05-01');                // start date
        $e = new DateTime('2021-05-28');                // end date
        $p = $this->utils->getPeriodDays($s, $e);       // get period

        echo "\n\n=======================================================================================\n";
        echo "> Creazione timbrate dipendenti, dal " . $s->format("Y-m-d") . " al " . $e->format("Y-m-d\n");
        echo "\n=======================================================================================\n\n";
        // loops through days in period
        foreach ($p as $dt) {
            $dow = $this->utils->getWeekday($dt);       // gets the day-of-week (sunday:0)
            if (($dow > 0) && ($dow < 6)) {

                // from monday to friday...
                echo $dt->format("Y-m-d\n");

                for ($i = 1; $i <= 25; $i++) {

                    // Generate a random entrance time for the current date/worker
                    $entrance = new DateTime($dt->format("Y-m-d") . ' 07:50:00');
                    $r = rand (1, 20);
                    $entrance = $entrance->add(new DateInterval('PT' . $r . 'M'));

                    // Generates a random exit time for the current date/worker
                    $exit = new DateTime($dt->format("Y-m-d") . ' 17:50:00');
                    $r = rand (1, 20);
                    $eixt = $exit->add(new DateInterval('PT' . $r . 'M'));

                    DB::table('attendances')->insertGetId(
                        array(
                            'worker' => $i,
                            'entrance_date' => $entrance,
                            'entrance_ip' => '0.0.0.0',
                            'exit_date' => $exit,
                            'exit_ip' => '0.0.0.0',
                            'check' => 1,
                            'created_at' => $entrance,
                            'updated_at' => $exit
                        )
                    );
                }
            } else {
                // Saturday or Sunday...
            }
        }

        echo "\nfinito!\n\n";

    }
}
