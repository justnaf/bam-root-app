<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelActiveEvent extends Model
{
    protected $fillable = [
        'user_id',
        'event_id',
        'status',
    ];

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function event()
    {
        return $this->hasMany(Event::class);
    }
}
