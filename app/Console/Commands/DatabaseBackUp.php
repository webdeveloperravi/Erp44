<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;

class DatabaseBackUp extends Command
{
    
    protected $signature = 'database:backup';

    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }

  
    public function handle()
    {

        $filename = "Database-backup-" . Carbon::now()->format('Y-m-d') . ".sql";
        $command = "mysqldump --user=" . env('DB_USERNAME') . " --password=" . env('DB_PASSWORD') . " --host=" . env('DB_HOST') . " " . env('DB_DATABASE') . " > " . storage_path() . "/databaseBackups/" . $filename;
        $returnVar = NULL;
        $output = NULL;
        exec($command, $output, $returnVar);
        return 0;
    }
}
