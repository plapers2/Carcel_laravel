<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistorialSession extends Model
{
    protected $fillable = [
        "user_id",
        "start_date",
        "finish_date",
        "ip",
        "user_agent"
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
