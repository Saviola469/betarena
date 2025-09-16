<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    protected $fillable = [
        'name', 'game_id', 'platform', 'max_participants', 'entry_fee', 'match_format', 'type', 'is_private', 'start_date', 'created_by', 'status'
    ];

    public function game() { return $this->belongsTo(Game::class); }
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
    public function players() { return $this->hasMany(TournamentPlayer::class); }
}
