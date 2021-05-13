<?php

namespace App\Http\Middleware;

use App\Models\Monitor;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use function PHPUnit\Framework\isNull;

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
        if (!$request->has(['token', 'monitor_mac'])) {
            return response("Wrong parameters", 400)
                ->header('Content-Type', 'text/plain');
        }

        if(!$monitor = Monitor::where("mac_address", "=", $request->monitor_mac)->first()) {
            return response("Mac address not found", 400)
                ->header('Content-Type', 'text/plain');
        }

        if ($request->input('token') !== Crypt::decryptString($monitor->token)) {
            return response("Wrong token", 403)
                ->header('Content-Type', 'text/plain');
        }

        return $next($request);
    }
}
