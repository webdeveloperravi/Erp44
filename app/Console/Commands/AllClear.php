<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class AllClear extends Command
{
    // Define command name
    protected $signature = 'all:clear';

    // Add description to your command
    protected $description = 'Clear Laravel all cache & logs';

    // Create your own custom command
    public function handle()
    {

        Artisan::call('config:cache');

        Artisan::call('cache:clear');

        Artisan::call('view:clear');

        Artisan::call('config:clear');

        exec('echo "" > ' . storage_path('logs/laravel.log'));

        $this->info('Application all cache and Logs cleared!');
    }
}
