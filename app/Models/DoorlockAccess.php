<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoorlockAccess extends Model
{
    use HasFactory;
    public $fillable = ['nama', 'token', 'level_akses','is_aktif'];
}
