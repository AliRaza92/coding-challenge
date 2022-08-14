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
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $handle = fopen(storage_path('app/logs.txt'),'r') or die ('File opening failed');
        $requestsCount = 0;
        $num404 = 0;


        $records = [];
        while (!feof($handle)) {
            $dd = fgets($handle); 
            $row = explode(" ",$dd);
            $record = [
                'service_name' => $row[0],
                'start_date' => ltrim($row[3],"[").' '.rtrim($row[4],"]"),
                'status_code' => $row[8],
                'log' => $dd
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
