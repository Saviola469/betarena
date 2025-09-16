<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClanUser extends Model
{
    protected $fillable = ['user_id','clan_id','status','role'];

    public function user() { return $this->belongsTo(User::class); }
    public function clan() { return $this->belongsTo(Clan::class); }
}
