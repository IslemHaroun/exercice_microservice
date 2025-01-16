<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DbMonitor extends Command
{
    protected $signature = 'db:monitor';
    protected $description = 'Monitor database connection';

    public function handle()
    {
        try {
            DB::connection()->getPdo();
            return 0;
        } catch (\Exception $e) {
            $this->error("Could not connect to the database.");
            return 1;
        }
    }
}