<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoorlockState extends Model
{
    use HasFactory;
    public $fillable = ['id_ruang', 'ruang', 'status'];
}
