<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clan extends Model
{
    protected $fillable = ['name','description','scoreClan'];

    public function users() { return $this->belongsToMany(User::class,'clan_users')->withPivot('role','status')->withTimestamps(); }
    public function clanUsers() { return $this->hasMany(ClanUser::class); }
}
