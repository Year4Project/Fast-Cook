<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Carbon\Carbon;

class DeleteOldTemporaryAccounts extends Command
{
    protected $signature = 'accounts:delete-old-temporary';
    protected $description = 'Delete temporary accounts older than 1 hour';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $oneHourAgo = Carbon::now()->subHour();
        $deleted = User::where('user_type', 4)
            ->where('created_at', '<', $oneHourAgo)
            ->delete();

        $this->info("Deleted {$deleted} temporary accounts.");
    }
}
