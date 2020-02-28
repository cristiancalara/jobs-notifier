<?php

namespace App\Console;

use App\Console\Commands\CreateUser;
use App\Console\Commands\GetAccessToken;
use App\Console\Commands\ImportJobs;
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
        CreateUser::class,
        GetAccessToken::class,
        ImportJobs::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('jobs-notifier:import-jobs')
                 ->everyFiveMinutes();

        $schedule->command('jobs-notifier:cleanup-jobs')
                 ->daily();

        $schedule->command('jobs-notifier:archive-jobs')
            ->weekly();
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
