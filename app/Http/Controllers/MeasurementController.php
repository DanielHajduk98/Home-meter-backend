<?php

namespace App\Http\Controllers;

use App\Models\Measurement;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PhpParser\Node\Scalar\String_;
use Ramsey\Collection\Collection;

class MeasurementController extends Controller
{
    private function parse($collection, $x, $y) {
        return $collection->map(function ($items) use ($x, $y) {
            $data['x'] = $items[$x];
            $data['y'] = $items[$y];
            return $data;
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index(Request $request)
    {
        if ($request->to == null && $request->from == null) {
            $request->to = Carbon::now();
            $request->from = Carbon::today();
        }
        $measurements = Measurement::where('created_at', '>=', $request->from)
            ->where('created_at', '<=', $request->to)
            ->get(['temperature', 'movement', 'luminosity', 'humidity', 'air_pressure', 'heat_index', 'created_at']);

        $temperature = $this->parse($measurements, 'created_at', "temperature");
        $movement = $this->parse($measurements, 'created_at', "movement");
        $luminosity = $this->parse($measurements, 'created_at', "luminosity");
        $air_pressure = $this->parse($measurements, 'created_at', "air_pressure");
        $humidity = $this->parse($measurements, 'created_at', "humidity");
        $heat_index = $this->parse($measurements, 'created_at', "heat_index");

        return [$temperature, $movement, $luminosity, $air_pressure, $humidity, $heat_index];
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return int
     */
    public function store()
    {
        Measurement::create(request(['temperature', 'humidity', 'air_pressure', 'movement', 'luminosity', 'heat_index']));

        return 200;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Measurement  $measurement
     * @return \Illuminate\Http\Response
     */
    public function show(Measurement $measurement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Measurement  $measurement
     * @return \Illuminate\Http\Response
     */
    public function edit(Measurement $measurement)
    {
        //
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
