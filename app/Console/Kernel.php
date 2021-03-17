<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'App\Console\Commands\Console',
        'App\Console\Commands\SendEmail',
        'App\Console\Commands\CancelOrder',
        'App\Console\Commands\WaOrderCreated',
        'App\Console\Commands\WaPaymentCreated',
        'App\Console\Commands\WaOrderApproved',
        'App\Console\Commands\WaPaymentApproved',
        'App\Console\Commands\TrackingOrder',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule) {
//        $schedule->command('email:system')->withoutOverlapping()->everyMinute();
        // $schedule->command('inspire')
        //          ->hourly();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands() {
        require base_path('routes/console.php');
    }

}
