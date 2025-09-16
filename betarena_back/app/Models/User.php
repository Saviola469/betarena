<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail

{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'pseudo',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relation avec le compte
    public function account() { return $this->hasOne(Account::class); }
    public function betsCreated() { return $this->hasMany(Bet::class, 'created_by'); }
    public function betPlayers() { return $this->hasMany(BetPlayer::class); }
    public function clans() { return $this->belongsToMany(Clan::class, 'clan_users')->withPivot('role','status')->withTimestamps(); }
    public function notifications() { return $this->hasMany(Notification::class); }
    public function badges() { return $this->belongsToMany(Badge::class, 'user_badges'); }

}
