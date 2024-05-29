<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnergiesForDev extends Model
{
    use HasFactory;
    protected $table = "energies_for_devs";
    protected $fillable = ['id_kwh', 'frekuensi', 'arus', 'tegangan', 'active_power', 'reactive_power', 'apparent_power', 'total_energy'];
}
