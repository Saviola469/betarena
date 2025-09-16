<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GroupConversation;
use App\Models\GroupMessage;
use App\Models\ClanUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupConversationController extends Controller
{
    // Récupérer la conversation de groupe d'un clan
    public function show($clan_id)
    {
        $conversation = GroupConversation::with('messages.sender')->where('clan_id', $clan_id)->firstOrFail();
        return response()->json($conversation);
    }

    // Envoyer un message dans la conversation de groupe
    public function send(Request $request, $clan_id)
    {
        $request->validate([
            'content' => 'required|string',
        ]);
        $user = $request->user();
        // Vérifie que l'utilisateur est membre du clan
        $isMember = ClanUser::where('clan_id', $clan_id)->where('user_id', $user->id)->where('status', 'active')->exists();
        if (!$isMember) {
            return response()->json(['message' => 'Accès refusé.'], 403);
        }
        $conversation = GroupConversation::where('clan_id', $clan_id)->firstOrFail();
        $message = $conversation->messages()->create([
            'sender_id' => $user->id,
            'content' => $request->content,
            'sent_at' => now(),
            'is_read' => false,
        ]);
        $conversation->last_message_at = now();
        $conversation->save();
        return response()->json($message, 201);
    }
}
