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
     */
    public function setupDevice(Request $request)
    {
        $monitor_mac = Monitor::where("mac_address", "=", $request->mac_address)->get(['mac_address']);

        if ($monitor_mac->isEmpty()) {
            $monitor = Monitor::create([
                'mac_address' => $request->mac_address
            ]);

            return 'Monitor setup successful';
        }
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
