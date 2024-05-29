<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DhtExtra extends Model
{
    use HasFactory;
    public $fillable = ['nama','id_nama'];
}
