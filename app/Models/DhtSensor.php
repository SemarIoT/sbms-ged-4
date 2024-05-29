<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DhtSensor extends Model
{
    protected $table = 'dht_sensors';
    use HasFactory;
    public $fillable = ['temperature', 'humidity'];
}
