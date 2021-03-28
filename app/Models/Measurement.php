<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Measurement extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function monitor() {
        return $this->belongsTo(Monitor::class, "macAddress");
    }
//    protected $fillable = [
//        'temperature', "heat_index", "luminosity", 'humidity', 'measurement'
//    ];
}
