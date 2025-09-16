<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupConversation extends Model
{
    protected $fillable = [
        'clan_id', 'name', 'last_message_at'
    ];

    public function clan() { return $this->belongsTo(Clan::class); }
    public function messages() { return $this->hasMany(GroupMessage::class); }
}
