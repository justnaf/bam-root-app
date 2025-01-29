<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelHistoryEvent extends Model
{
    protected $fillable = [
        'user_id',
        'event_name',
        'status',
        'desc',
        'status_rtl',
        'desc',
    ];

    public function user()
    {
        return $this->hasMany(User::class);
    }
}
