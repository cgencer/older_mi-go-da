<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use App\Models\GlobalSettings;
use App\Models\Reservation;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands, Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\other\tst::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule) {

        $res = new Reservation();
        $schedule->call($res->checkAllReservations())->everyMinute();
        //dakika başı tüm rezervasyonları kontrol edip mail
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
