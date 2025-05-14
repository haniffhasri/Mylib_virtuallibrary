<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Borrow;
use Carbon\Carbon;

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
        $now = Carbon::now();

        $expiredBorrows = Borrow::where('is_active', true)
            ->where('due_date', '<', $now)
            ->update(['is_active' => false]);

        $this->info("Expired borrows updated successfully!");
    }
}
