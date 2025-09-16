<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tournament;
use App\Models\TournamentPlayer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TournamentController extends Controller
{
    // Liste des tournois avec filtres et pagination
    public function index(Request $request)
    {
        $query = Tournament::with('game', 'creator', 'players.user');
        if ($request->has('game_id')) {
            $query->where('game_id', $request->game_id);
        }
        if ($request->has('platform')) {
            $query->where('platform', $request->platform);
        }
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }
        $perPage = $request->get('per_page', 10);
        $tournaments = $query->orderByDesc('created_at')->paginate($perPage);
        return response()->json($tournaments);
    }

    // Créer un tournoi
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'game_id' => 'required|exists:games,id',
            'platform' => 'required|string',
            'max_participants' => 'required|integer|min:2',
            'entry_fee' => 'required|numeric|min:0',
            'match_format' => 'nullable|string',
            'type' => 'required|in:elimination,round_robin,other',
            'is_private' => 'boolean',
            'start_date' => 'nullable|date',
        ]);
        $tournament = Tournament::create([
            'name' => $request->name,
            'game_id' => $request->game_id,
            'platform' => $request->platform,
            'max_participants' => $request->max_participants,
            'entry_fee' => $request->entry_fee,
            'match_format' => $request->match_format,
            'type' => $request->type,
            'is_private' => $request->is_private ?? false,
            'start_date' => $request->start_date,
            'created_by' => Auth::id(),
            'status' => 'planned',
        ]);
        return response()->json($tournament, 201);
    }

    // Détail d'un tournoi
    public function show($id)
    {
        $tournament = Tournament::with('game', 'creator', 'players.user')->findOrFail($id);
        return response()->json($tournament);
    }

    // Inscription à un tournoi
    public function register(Request $request, $id)
    {
        $tournament = Tournament::findOrFail($id);
        $user = $request->user();
        // Vérifie si déjà inscrit
        $exists = $tournament->players()->where('user_id', $user->id)->exists();
        if ($exists) {
            return response()->json(['message' => 'Déjà inscrit à ce tournoi.'], 409);
        }
        // Vérifie la limite de participants
        if ($tournament->players()->count() >= $tournament->max_participants) {
            return response()->json(['message' => 'Tournoi complet.'], 403);
        }
        $player = $tournament->players()->create([
            'user_id' => $user->id,
            'status' => 'pending',
            'score' => 0,
        ]);
        return response()->json($player, 201);
    }
}
