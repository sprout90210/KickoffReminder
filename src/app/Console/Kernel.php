<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('command:insertTeams')->weeklyOn(1, '00:01');
        $schedule->command('command:updateSeasons')->weeklyOn(2, '00:01');
        $schedule->command('command:updateStandings')->cron('5,15,25,35,45,55 * * * *');
        $schedule->command('command:updateGames')->everyTenMinutes();
        $schedule->command('command:sendReminder')->everyMinute();

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
