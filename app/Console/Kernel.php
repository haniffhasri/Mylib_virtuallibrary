<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use \App\Console\Commands\UpdateExpiredBorrows;
use  Illuminate\Support\Facades\Log;
class Kernel extends ConsoleKernel
{
    protected $commands = [
        UpdateExpiredBorrows::class, 
    ];

    protected function schedule(Schedule $schedule)
    {
        Log::info("Scheduler ran at " . now());

        $schedule->command('app:update-expired-borrows')
            ->everyMinute()
            ->withoutOverlapping()
            ->before(function () {
                Log::info("Starting: app:update-expired-borrows at " . now());
            })
            ->after(function () {
                Log::info("Finished: app:update-expired-borrows at " . now());
            });

        $schedule->command('backup:run')
            ->daily()->at('5:00')
            ->withoutOverlapping()
            ->before(fn () => Log::info("Starting: backup:run"))
            ->after(fn () => Log::info("Finished: backup:run"));

        $schedule->command('backup:clean')
            ->daily()->at('5:00')
            ->withoutOverlapping()
            ->before(fn () => Log::info("Starting: backup:clean"))
            ->after(fn () => Log::info("Finished: backup:clean"));

        $schedule->command('backup:monitor')
            ->daily()->at('5:00')
            ->withoutOverlapping()
            ->before(fn () => Log::info("Starting: backup:monitor"))
            ->after(fn () => Log::info("Finished: backup:monitor"));
    }


    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
