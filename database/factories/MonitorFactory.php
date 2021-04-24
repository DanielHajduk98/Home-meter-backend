<?php

namespace Database\Factories;

use App\Models\Monitor;
use Illuminate\Database\Eloquent\Factories\Factory;

class MonitorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Monitor::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'mac_address' => '73:B1:1D:30:40:12',
            'token' => 'ERvLtDpyH3oqhkgW7PLMPBfXQDAJ9IW5'
        ];
    }
}
