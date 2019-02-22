<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Carbon\Carbon;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use DB;
use Storage;
use File;

class BackupData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:db';

    protected $database;

    protected $path;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'backup database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->database = env('DB_DATABASE');
        $this->path = storage_path(config('settings.path_backup_data'));
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $file = File::allFiles($this->path);

        if (empty($file)) {
            $this->backup();
        } else {
            $tables = DB::select('SHOW TABLES');
            $tableName = 'Tables_in_'.$this->database;
            foreach ($tables as $table) {
                $status = DB::select('select * from information_schema.tables WHERE TABLE_SCHEMA ="'.$this->database.'" AND TABLE_NAME = "'.$table->$tableName.'"');
                $preBackupDay = Carbon::now()->subDays(config('settings.number_day_backup'));
                $updateTime = $status[0]->UPDATE_TIME;

                if ($updateTime == null) {
                    continue;
                } else {
                    $updateTime = Carbon::createFromTimeString($updateTime);

                    if ($updateTime->greaterThan($preBackupDay)) {
                        $this->backup();
                        break;
                    }
                }
            }
        }
    }

    public function backup()
    {
        try {
            $password = env('DB_PASSWORD');
            $userName = env('DB_USERNAME');
            $dateTime = Carbon::now();
            $dateTimeString = $dateTime->format('Y_m_d_H_i_s');
            $fileName = $dateTimeString.'.sql';
            $shellCommand = 'mysqldump '.$this->database.' --password='.$password .' --user='.$userName . ' --quick > '.$this->path.'/'.$fileName;
            $process = new Process($shellCommand);
            $process->run();

            $this->info('Backup successfuly!');
            } catch (Exception $e) {
                $this->info('backup database failed!');
            }
    }
}
