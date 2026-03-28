<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class visitors extends Model
{
    protected $fillable = ['name', 'identification_number'];
    public function visits()
    {
        return $this->hasMany(Visits::class);
    }
}
