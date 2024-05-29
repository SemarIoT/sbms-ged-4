<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pinpoint extends Model
{
    use HasFactory;
    protected $fillable = ['id_nama','nama','xpos','ypos'];
}
