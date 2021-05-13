<?php

namespace App\Http\Controllers;

use App\Models\Monitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class MonitorController extends Controller
{
    /**
     * Check if monitor is in DB. If not create new instance and return token.
     * Save encrypted token in DB.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function setupDevice(Request $request)
    {
        $monitor_mac = Monitor::where("mac_address", "=", $request->mac_address)->get(['mac_address']);

        if ($monitor_mac->isEmpty()) {
            $token = Str::random(32);

            $monitor = Monitor::create([
                'mac_address' => $request->mac_address,
                'token' => Crypt::encryptString($token)
            ]);

            return response($token, 200)
                ->header('Content-Type', 'text/plain');
        }

        return response("Monitor already in DB", 200)
            ->header('Content-Type', 'text/plain');

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
