<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        'name', 'genre', 'platform', 'cover_url', 'description'
    ];

    public function tournaments() { return $this->hasMany(Tournament::class); }
    public function bets() { return $this->hasMany(Bet::class); }
    public function matchs() { return $this->hasMany(Matchs::class); }
}
