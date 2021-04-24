<?php

namespace App\Http\Middleware;

use App\Models\Monitor;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class CheckMonitorToken
{
    /**
     * Check if monitor's token is valid.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $token = Monitor::where("mac_address", "=", $request->monitor_mac)->first()->token;

        if ($request->input('token') !== Crypt::decryptString($token)) {
            return response("403", 403)
                ->header('Content-Type', 'text/plain')
                ->header('Content-Length', '255');
        }

        return $next($request);
    }
}
