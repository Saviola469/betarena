<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bet extends Model
{
    protected $fillable = ['created_by','match_id','type','stake','is_clanBet','status'];

    public function creator() { return $this->belongsTo(User::class,'created_by'); }
    public function match() { return $this->belongsTo(Matchs::class); }
    public function players() { return $this->hasMany(BetPlayer::class); }
    public function evidences() { return $this->hasMany(Evidence::class); }
}