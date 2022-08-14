<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Log;

class ReadLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'read:logs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parsing the log file';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //Parsing the file stored in storage
        $handle = fopen(storage_path('app/logs.txt'),'r') or die ('File opening failed');

        $records = [];
        while (!feof($handle)) {
            $logList = fgets($handle); 
            $row = explode(" ",$logList);
            $record = [
                'service_name' => $row[0],
                'start_date' => ltrim($row[3],"[").' '.rtrim($row[4],"]"),
                'status_code' => $row[8],
                'log' => $logList
            ];
            
            array_push($records,$record);
            
            if(count($records) > 10000) {
                Log::insert($records);
                $records = [];
            } 
        }

        if(count($records)) {
            Log::insert($records);
        }

        fclose($handle);
    }
}
