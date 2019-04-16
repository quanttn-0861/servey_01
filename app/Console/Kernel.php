<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\CloseSurveyCommand::class,
        Commands\OpenSurveyCommand::class,
        Commands\ResendReminderEmailCommand::class,
        Commands\BackupDatabaseCommand::class,
        Commands\ResendEmailRemindTimeRemaining::class,
        Commands\CleanMediaCommand::class,
        Commands\BackupData::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('command:auto-close-survey')->everyMinute();
        $schedule->command('command:auto-open-survey')->everyMinute();
        $schedule->command('backup:database')->weekly();
        $schedule->command('command:resend-email-remind-time-remaining')->everyMinute();
        $schedule->command('command:send-reminder-email')->everyMinute();
        $schedule->command('command:clean-media')->dailyAt('00:00');
        $schedule->command('backup:db')->weekly()->fridays()->at('17:30');;
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
