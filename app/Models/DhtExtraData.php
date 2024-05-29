<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DhtExtraData extends Model
{
    use HasFactory;
    public $fillable = ['dht','temperature', 'humidity'];
}

