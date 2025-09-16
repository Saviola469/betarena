<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BetPlayer extends Model
{
    protected $fillable = ['bet_id','user_id','clan_id','result','status'];

    public function bet() { return $this->belongsTo(Bet::class); }
    public function user() { return $this->belongsTo(User::class); }
    public function clan() { return $this->belongsTo(Clan::class); }
}
