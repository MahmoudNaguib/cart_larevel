<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\Log;
use File;

class Backup extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup all databases';
    protected $process;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        if (app()->environment() == 'production') {
            try {
                $today = today()->format('Y-m-d');
                $path = 'backups/' . $today;
                if (!File::isDirectory(storage_path() . '/backups')) {
                    File::makeDirectory(storage_path() . '/backups', 0777, true, true);
                }
                if (!File::isDirectory(storage_path() . '/' . $path)) {
                    File::makeDirectory(storage_path() . '/' . $path, 0777, true, true);
                }
                $username = env('DB_USERNAME');
                $password = env('DB_PASSWORD');
                $db = env('DB_DATABASE');
                // backup the whole database
                $command = "mysqldump --compact --skip-comments -u {$username} --password={$password} {$db}| gzip -c> " . storage_path($path) . '/' . $db . '.sql.gz';
                $this->process = new Process($command);
                $this->process->mustRun();
                ////////////////////////////////////////////// backup attachment
                $uploadsName = 'uploads';
                $compressedPath = storage_path() . '/' . $path . '/' . $uploadsName . '.tar.gz';
                $command = "tar -C " . public_path() . " -czvf " . $compressedPath . ' ' . $uploadsName;
                $this->process = new Process($command);
                $this->process->mustRun();
            } catch (Exception $exception) {
                \Log::error('Error: ' . $e->getMessage() . ', File: ' . $e->getFile() . ', Line:' . $e->getLine() . PHP_EOL);
            }
        }
    }

}
