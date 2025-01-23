<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReadInterest extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'name',
        'authors',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
