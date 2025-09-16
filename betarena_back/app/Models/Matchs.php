<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matchs extends Model
{
    protected $fillable = ['play','players','start_time','status','result'];
    public function bets() { return $this->hasMany(Bet::class); }
}
