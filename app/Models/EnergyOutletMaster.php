<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnergyOutletMaster extends Model
{
    use HasFactory;
    protected $fillable = ['nama','status'];

}
