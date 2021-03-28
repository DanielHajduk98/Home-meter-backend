<?php

namespace App\Http\Controllers;

use App\Models\Monitor;
use Illuminate\Http\Request;

class MonitorController extends Controller
{
    /**
     * Check if monitor is in DB. If not create new instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return int
     */
    public function setupDevice(Request $request)
    {
        $monitor_mac = Monitor::where("macAddress", "=", $request->macAddress)->get(['macAddress']);

        if ($monitor_mac->isEmpty()) {
            $monitor = Monitor::create([
                'macAddress' => $request->macAddress,
                'name' => "",
            ]);

            return 'Monitor setup successful';
        }

        return "Monitor already in db";
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
