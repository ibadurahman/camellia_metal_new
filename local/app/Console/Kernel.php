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
        // $schedule->command('downtime:close')->dailyAt('07:00');
        // $schedule->command('downtime:close')->dailyAt('11:30');
        // $schedule->command('downtime:close')->dailyAt('12:30');
        // $schedule->command('downtime:close')->dailyAt('16:00');
        // $schedule->command('downtime:close')->dailyAt('18:00');
        // $schedule->command('downtime:close')->dailyAt('19:00');
        // $schedule->command('downtime:close')->dailyAt('00:00');

        // Normal day schedule monday to thursday
        $schedule->command('downtime:close')->dailyAt('07:00')->when(function () {
            return Carbon::now()->dayOfWeek !== Carbon::FRIDAY || Carbon::now()->dayOfWeek !== Carbon::SATURDAY || Carbon::now()->dayOfWeek !== Carbon::SUNDAY;
        });
        $schedule->command('downtime:close')->dailyAt('11:30')->when(function () {
            return Carbon::now()->dayOfWeek !== Carbon::FRIDAY || Carbon::now()->dayOfWeek !== Carbon::SATURDAY || Carbon::now()->dayOfWeek !== Carbon::SUNDAY;
        });
        $schedule->command('downtime:close')->dailyAt('12:00')->when(function () {
            return Carbon::now()->dayOfWeek !== Carbon::FRIDAY || Carbon::now()->dayOfWeek !== Carbon::SATURDAY || Carbon::now()->dayOfWeek !== Carbon::SUNDAY;
        });
        $schedule->command('downtime:close')->dailyAt('15:00')->when(function () {
            return Carbon::now()->dayOfWeek !== Carbon::FRIDAY || Carbon::now()->dayOfWeek !== Carbon::SATURDAY || Carbon::now()->dayOfWeek !== Carbon::SUNDAY;
        });
        $schedule->command('downtime:close')->dailyAt('18:00')->when(function () {
            return Carbon::now()->dayOfWeek !== Carbon::FRIDAY || Carbon::now()->dayOfWeek !== Carbon::SATURDAY || Carbon::now()->dayOfWeek !== Carbon::SUNDAY;
        });
        $schedule->command('downtime:close')->dailyAt('19:00')->when(function () {
            return Carbon::now()->dayOfWeek !== Carbon::FRIDAY || Carbon::now()->dayOfWeek !== Carbon::SATURDAY || Carbon::now()->dayOfWeek !== Carbon::SUNDAY;
        });
        $schedule->command('downtime:close')->dailyAt('23:00')->when(function () {
            return Carbon::now()->dayOfWeek !== Carbon::FRIDAY || Carbon::now()->dayOfWeek !== Carbon::SATURDAY || Carbon::now()->dayOfWeek !== Carbon::SUNDAY;
        });

        // Friday schedule
        $schedule->command('downtime:close')->dailyAt('07:00')->when(function () {
            return Carbon::now()->dayOfWeek === Carbon::FRIDAY;
        });
        $schedule->command('downtime:close')->dailyAt('11:30')->when(function () {
            return Carbon::now()->dayOfWeek === Carbon::FRIDAY;
        });
        $schedule->command('downtime:close')->dailyAt('13:00')->when(function () {
            return Carbon::now()->dayOfWeek === Carbon::FRIDAY;
        });
        $schedule->command('downtime:close')->dailyAt('15:00')->when(function () {
            return Carbon::now()->dayOfWeek === Carbon::FRIDAY;
        });
        $schedule->command('downtime:close')->dailyAt('18:00')->when(function () {
            return Carbon::now()->dayOfWeek === Carbon::FRIDAY;
        });
        $schedule->command('downtime:close')->dailyAt('19:00')->when(function () {
            return Carbon::now()->dayOfWeek === Carbon::FRIDAY;
        });
        $schedule->command('downtime:close')->dailyAt('23:00')->when(function () {
            return Carbon::now()->dayOfWeek === Carbon::FRIDAY;
        });

        // Saturday schedule
        $schedule->command('downtime:close')->dailyAt('07:00')->when(function () {
            return Carbon::now()->dayOfWeek === Carbon::SATURDAY;
        });
        $schedule->command('downtime:close')->dailyAt('12:00')->when(function () {
            return Carbon::now()->dayOfWeek === Carbon::SATURDAY;
        });
        $schedule->command('downtime:close')->dailyAt('17:00')->when(function () {
            return Carbon::now()->dayOfWeek === Carbon::SATURDAY;
        });
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
