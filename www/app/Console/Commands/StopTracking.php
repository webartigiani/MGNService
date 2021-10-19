<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;

class StopTracking extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:stoptracking';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Stops All Tracking Sessions';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $time = Carbon::now()->toDateTimeString();
        $this->info("Comando '{$this->signature}' eseguito: {$time}");
        return 0;
    }
}
