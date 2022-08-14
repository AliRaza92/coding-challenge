<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Log;


class LogController extends Controller
{
    public function __invoke(Request $request)
    {
        $query = Log::query();

        $query->when($request->has('serviceNames'), function ($query) use ($request) {
            $query->where('service_name', $request->serviceNames);
        });
        $query->when($request->has('statusCode'), function ($query) use ($request) {
            $query->where('status_code', $request->serviceNames);
        });
        $query->when($request->has('startDate'), function ($query) use ($request) {
            $query->where('start_date', $request->serviceNames);
        });
        $query->when($request->has('log'), function ($query) use ($request) {
            $query->where('log', $request->serviceNames);
        })
        ->get();
    }
}
