<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Borrow;
use Carbon\Carbon;
use  Illuminate\Support\Facades\Log;

class UpdateExpiredBorrows extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-expired-borrows';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::info('Command is running at ' . now());

        $now = now();
        $expiredBorrows = Borrow::where('is_active', true)
            ->where('due_date', '<', $now)
            ->get();

        if ($expiredBorrows->isEmpty()) {
            $this->info('No expired borrows found.');
            Log::info('No expired borrows found.');
        } else {
            Borrow::whereIn('id', $expiredBorrows->pluck('id'))->update(['is_active' => false]);
            $this->info("Updated " . $expiredBorrows->count() . " expired borrows.");
            Log::info("Updated " . $expiredBorrows->count() . " expired borrows.");
        }

        return 0; 
    }

}
