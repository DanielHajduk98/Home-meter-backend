<?php

namespace App\Http\Controllers;

use App\Models\Monitor;
use Illuminate\Http\Request;

class MonitorController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return int
     */
    public function store(Request $request)
    {
        $monitor = Monitor::create(request(['macAddress', 'name']));

        return $monitor->id;
    }

    /**
     * Update monitor.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return int
     */
    public function update(Request $request)
    {
        $monitor = Monitor::find($request->id);

        $monitor->name = $request->name;

        $monitor->save();

        return 200;
    }
}
