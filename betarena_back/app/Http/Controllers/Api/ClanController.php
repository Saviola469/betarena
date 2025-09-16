<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Clan;
use App\Models\ClanUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClanController extends Controller
{
    // Liste des clans avec filtres et pagination
    public function index(Request $request)
    {
        $query = Clan::with('users', 'clanUsers.user');
        if ($request->has('platform')) {
            $query->where('platform', $request->platform);
        }
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }
        $perPage = $request->get('per_page', 10);
        $clans = $query->orderByDesc('created_at')->paginate($perPage);
        return response()->json($clans);
    }

    // Créer un clan
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:clans,name',
            'description' => 'nullable|string',
            'platform' => 'required|string',
            'type' => 'required|in:public,private',
            'max_members' => 'required|integer|min:5|max:100',
        ]);
        $clan = Clan::create([
            'name' => $request->name,
            'description' => $request->description,
            'platform' => $request->platform,
            'type' => $request->type,
            'max_members' => $request->max_members,
        ]);
        // Ajoute le créateur comme capitaine
        ClanUser::create([
            'user_id' => Auth::id(),
            'clan_id' => $clan->id,
            'role' => 'captain',
            'status' => 'active',
        ]);
        // Crée automatiquement la conversation de groupe du clan
        \App\Models\GroupConversation::create([
            'clan_id' => $clan->id,
            'name' => 'Conversation de clan',
            'last_message_at' => null,
        ]);
        return response()->json($clan, 201);
    }

    // Détail d'un clan
    public function show($id)
    {
        $clan = Clan::with('users', 'clanUsers.user')->findOrFail($id);
        return response()->json($clan);
    }

    // Rejoindre ou candidater à un clan
    public function join(Request $request, $id)
    {
        $clan = Clan::findOrFail($id);
        $user = $request->user();
        // Vérifie si déjà membre
        $exists = $clan->clanUsers()->where('user_id', $user->id)->exists();
        if ($exists) {
            return response()->json(['message' => 'Déjà membre ou candidature en cours.'], 409);
        }
        // Vérifie la limite de membres
        if ($clan->clanUsers()->count() >= $clan->max_members) {
            return response()->json(['message' => 'Clan complet.'], 403);
        }
        $role = 'member';
        $status = $clan->type === 'public' ? 'active' : 'pending';
        $clanUser = $clan->clanUsers()->create([
            'user_id' => $user->id,
            'role' => $role,
            'status' => $status,
        ]);
        return response()->json($clanUser, 201);
    }
}
