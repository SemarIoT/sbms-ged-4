<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoorlockHistory extends Model
{
    use HasFactory;
    public $fillable = ['id_ruang', 'ruang','nama','status'];
}
