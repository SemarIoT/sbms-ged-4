<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FireAlarm extends Model
{
    use HasFactory;
    public $fillable = ['nama','status'];
}
