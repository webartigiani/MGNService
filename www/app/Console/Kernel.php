<?php
/*
    Create new command
        php artisan make:command CommandName
    Schedule
        php artisan schedule:list       // lists all running schedules
        php artisan schedule:run        // runs schedules
        php artisan schedule:work       // runs schedules on local development machine
**/
namespace App\Console;

use App\Console\Commands\DemoCommand;
use App\Console\Commands\StopTracking;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Storage;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        /*
        $path = 'storage/logs';
        $schedule->command(StopTracking::class)
            ->everyMinute()
            ->appendOutputTo("{$path}/Scheduler-StopTracking.txt");
        */
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
