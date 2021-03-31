<?php

namespace App\Http\Controllers;

use App\Events\NewMeasurementStored;
use App\Models\Measurement;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PhpParser\Node\Scalar\String_;
use Ramsey\Collection\Collection;

class MeasurementController extends Controller
{
    private function parse($collection, $y) {
        return $collection->map(function ($items) use ($y) {
            $data['x'] = $items['created_at'];
            $data['y'] = $items[$y];
            return $data;
        });
    }

    private function parseMeasurements($measurements): array
    {
        $temperature = [
            "name" => "Temperature",
            "data" => $this->parse($measurements, "temperature")
        ];

        $movement = [
            "name" => "Movement",
            "data" => $this->parse($measurements, "movement")
        ];
        $luminosity = [
            "name" => "Luminosity",
            "data" => $this->parse($measurements, "luminosity")
        ];
        $air_pressure = [
            "name" => "Air Pressure",
            "data" => $this->parse($measurements, "air_pressure")
        ];
        $humidity = [
            "name" => "Humidity",
            "data" => $this->parse($measurements, "humidity")
        ];
        $heat_index = [
            "name" => "Heat index",
            "data" => $this->parse($measurements, "heat_index")
        ];

        return [$temperature, $movement, $luminosity, $air_pressure, $humidity, $heat_index];
    }
//    /**
//     * Get
//     *
//     * @return array
//     */
//    public function index(Request $request)
//    {
//        $measurements = Measurement::get(['temperature', 'movement', 'luminosity', 'humidity', 'air_pressure', 'heat_index', 'created_at']);
//
//        return $this->parseMeasurements($measurements);
//    }

    /**
     * Get measurements from today
     *
     * @return array
     */
    public function getToday(Request $request)
    {
        $measurements = Measurement::whereDate('created_at', Carbon::today())
            ->get(['monitor_mac', 'temperature', 'movement', 'luminosity', 'humidity', 'air_pressure', 'heat_index', 'created_at']);

        return $this->parseMeasurements($measurements);
    }

    /**
     * Get measurements from given date
     *
     * @return array
     */
    public function getDay(Request $request): array
    {

        $measurements = Measurement::whereDate('created_at', Carbon::createFromIsoFormat('YYYY-MM-DD' , $request->date))
            ->orderBy("created_at", "desc")
            ->get(['monitor_mac', 'temperature', 'movement', 'luminosity', 'humidity', 'air_pressure', 'heat_index', 'created_at']);

        $measurements = $this->parseMeasurements($measurements);

        return $measurements;
    }

    public function getMonth(Request $request): array
    {
        $measurements = Measurement::whereMonth('created_at', Carbon::createFromIsoFormat('YYYY-MM-DD' , $request->date))
            ->orderBy('created_at', 'desc')
            ->get(['monitor_mac', 'temperature', 'movement', 'luminosity', 'humidity', 'air_pressure', 'heat_index', 'created_at']);

        return $this->parseMeasurements($measurements);
    }

    public function getYear(Request $request): array
    {
        $measurements = Measurement::whereYear('created_at', Carbon::createFromIsoFormat('YYYY-MM-DD' , $request->date))
            ->orderBy('created_at', 'desc')
            ->get(['monitor_mac', 'temperature', 'movement', 'luminosity', 'humidity', 'air_pressure', 'heat_index', 'created_at']);

        return $this->parseMeasurements($measurements);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return int
     */
    public function store()
    {
        $measurement = Measurement::create(request(['monitor_mac', 'temperature', 'humidity', 'air_pressure', 'movement', 'luminosity', 'heat_index']));

        NewMeasurementStored::dispatch([
            ["y" => $measurement->temperature, "x" => $measurement->created_at],
            ["y" => $measurement->movement, "x" => $measurement->created_at],
            ["y" => $measurement->luminosity, "x" => $measurement->created_at],
            ["y" => $measurement->air_pressure, "x" => $measurement->created_at],
            ["y" => $measurement->humidity, "x" => $measurement->created_at],
            ["y" => $measurement->heat_index, "x" => $measurement->created_at],
        ]);

        return 200;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Measurement  $measurement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Measurement $measurement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Measurement  $measurement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Measurement $measurement)
    {
        //
    }
}
