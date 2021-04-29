<?php
namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;

class AppBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make application backup';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $path = storage_path() . "/app/backup/";

        if (!file_exists($path)) {
            mkdir($path);
            echo "The directory $path was successfully created.";
            exit;
        } else {
            echo "The directory $path exists.";
        }

        $filename = env('APP_NAME') . "-" . Carbon::now()->format('Y-m-d_H-i') . ".tar.gz";
        $command = "tar --exclude='./storage' --exclude='./vendor' --exclude='./.git' -zcvf " . storage_path() . "/app/backup/" . $filename . " .";
        $returnVar = null;
        $output = null;
        exec($command, $output, $returnVar);
    }
}
