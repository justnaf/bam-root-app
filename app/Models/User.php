<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'code',
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    // Event Binding
    public function modelRequestRole()
    {
        return $this->hasMany(ModelRequestRole::class);
    }

    public function event()
    {
        return $this->hasMany(Event::class);
    }

    public function modelActiveEvent()
    {
        return $this->hasMany(ModelActiveEvent::class);
    }

    public function modelHistoryEvent()
    {
        return $this->hasMany(ModelHistoryEvent::class);
    }

    public function presenceHistory()
    {
        return $this->hasMany(PresenceHistory::class);
    }
    // End Event Binding


    // Detail Of User
    public function dataDiri()
    {
        return $this->hasOne(DataDiri::class);
    }

    public function eduHist()
    {
        return $this->hasMany(EduHistories::class);
    }
    public function orgHist()
    {
        return $this->hasMany(OrgHistories::class);
    }

    public function ownPaper()
    {
        return $this->hasMany(OwnPaper::class);
    }

    public function ownAchieve()
    {
        return $this->hasMany(OwnAchievement::class);
    }

    public function readInterest()
    {
        return $this->hasMany(ReadInterest::class);
    }

    // end Detail Of User
}
