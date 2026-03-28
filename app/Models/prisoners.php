<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class prisoners extends Model
{
    protected $fillable = ['name', 'birth_date', 'admission_date', 'offense', 'assigned_cell'];
}
