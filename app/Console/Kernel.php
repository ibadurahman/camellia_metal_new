<?php

namespace App\Console;

use Illuminate\Support\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        if (Carbon::now()->format('G') == '7') {
            $schedule->command('downtime:close')->dailyAt('07:00');
        }
        if (Carbon::now()->format('G') == '11') {
            $schedule->command('downtime:close')->dailyAt('11:30');
        }
        if (Carbon::now()->format('G') == '12') {
            $schedule->command('downtime:close')->dailyAt('12:30');
        }
        if (Carbon::now()->format('G') == '16') {
            $schedule->command('downtime:close')->dailyAt('16:00');
        }
        if (Carbon::now()->format('G') == '18') {
            $schedule->command('downtime:close')->dailyAt('18:00');
        }
        if (Carbon::now()->format('G') == '19') {
            $schedule->command('downtime:close')->dailyAt('19:00');
        }
        if (Carbon::now()->format('G') == '0') {
            $schedule->command('downtime:close')->dailyAt('00:00');
        }
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}