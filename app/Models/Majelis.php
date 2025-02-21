<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Majelis extends Model
{
    protected $fillable = [
        'user_id',
        'code',
        'name',
        'desc',
        'loc_name',
        'loc_link',
        'status',
        'category',
        'start_date',
        'end_date',
    ];

    public function presence()
    {
        return $this->hasMany(PresenceMajelis::class);
    }
}
