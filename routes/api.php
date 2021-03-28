<?php

use App\Http\Controllers\MonitorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use \App\Http\Controllers\MeasurementController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/measurement', [MeasurementController::class, 'store']);
Route::get('/measurement', [MeasurementController::class, 'getToday']);
Route::get('/measurement/day', [MeasurementController::class, 'getDay']);
Route::get('/measurement/month', [MeasurementController::class, 'getMonth']);
Route::get('/measurement/year', [MeasurementController::class, 'getYear']);

Route::post("/monitor", [MonitorController::class, 'setupDevice']);
Route::post("/monitor/update", [MonitorController::class, 'update']);

