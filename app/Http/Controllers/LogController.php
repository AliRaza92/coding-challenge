<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Log;


class LogController extends Controller
{
    public function __invoke(Request $request)
    {
        //Quering the model for result
        $query = Log::query();

        //if request service name
        $query->when($request->has('serviceNames'), function ($query) use ($request) {
            $query->where('service_name', $request->serviceNames);
        });

        //if request status code
        $query->when($request->has('statusCode'), function ($query) use ($request) {
            $query->where('status_code', $request->serviceNames);
        });

        //if request start date
        $query->when($request->has('startDate'), function ($query) use ($request) {
            $query->where('start_date', $request->serviceNames);
        });

        //if request log
        $query->when($request->has('log'), function ($query) use ($request) {
            $query->where('log', $request->serviceNames);
        });

        $logList = $query->get()->count();
        
        return json_encode(['counter' => $logList]);
    }
}
