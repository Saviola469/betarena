<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    // Liste des conversations de l'utilisateur
    public function conversations(Request $request)
    {
        $user = $request->user();
        $convos = Conversation::where('user_one_id', $user->id)
            ->orWhere('user_two_id', $user->id)
            ->with(['userOne', 'userTwo', 'messages' => function($q) { $q->latest(); }])
            ->orderByDesc('last_message_at')
            ->get();
        return response()->json($convos);
    }

    // Liste des messages d'une conversation
    public function messages($conversation_id)
    {
        $messages = Message::where('conversation_id', $conversation_id)
            ->with('sender')
            ->orderBy('sent_at')
            ->get();
        return response()->json($messages);
    }

    // Envoyer un message dans une conversation
    public function send(Request $request, $conversation_id)
    {
        $request->validate([
            'content' => 'required|string',
        ]);
        $user = $request->user();
        $conversation = Conversation::findOrFail($conversation_id);
        // Vérifie que l'utilisateur fait partie de la conversation
        if ($conversation->user_one_id !== $user->id && $conversation->user_two_id !== $user->id) {
            return response()->json(['message' => 'Accès refusé.'], 403);
        }
        $message = Message::create([
            'conversation_id' => $conversation_id,
            'sender_id' => $user->id,
            'content' => $request->content,
            'sent_at' => now(),
            'is_read' => false,
        ]);
        // Met à jour la date du dernier message
        $conversation->last_message_at = now();
        $conversation->save();
        return response()->json($message, 201);
    }
}
