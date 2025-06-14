<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\UpdateExpiredBorrows::class, // Register your command here
    ];

    protected function schedule(Schedule $schedule)
    {
        // Schedule your command here
        $schedule->command('borrows:update-expired')->daily();
        $schedule->command('backup:run')->daily()->at('5:00');
        $schedule->command('backup:clean')->daily()->at('5:00');
        $schedule->command('backup:monitor')->daily()->at('5:00');
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
