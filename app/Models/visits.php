<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class visits extends Model
{
    protected $fillable = ['visitor_relationship', 'start_date', 'end_date', 'verification', 'prisoners_id', 'visitors_id', 'users_id'];
    public function visitor()
    {
        return $this->belongsTo(visitors::class);
    }
    public function prisoner()
    {
        return $this->belongsTo(prisoners::class);
    }
    public function user()
    {
        return $this->belongsTo(user::class);
    }
}
