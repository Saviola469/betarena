<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupMessage extends Model
{
    protected $fillable = [
        'group_conversation_id', 'sender_id', 'content', 'sent_at', 'is_read'
    ];

    public function groupConversation() { return $this->belongsTo(GroupConversation::class); }
    public function sender() { return $this->belongsTo(User::class, 'sender_id'); }
}
