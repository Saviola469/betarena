<?php

namespace App\Http\Controllers;

use App\Models\BetPlayer;
use App\Models\Bet;
use App\Models\User;
use App\Models\Clan;
use Illuminate\Http\Request;

class BetPlayerController extends Controller
{
    /**
     * Lister tous les joueurs sur les paris
     * Possibilité de filtrer par bet_id ou user_id via query params
     */
    public function index(Request $request)
    {
        $query = BetPlayer::with('bet.creator', 'user', 'clan');

        if ($request->has('bet_id')) {
            $query->where('bet_id', $request->bet_id);
        }

        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        return response()->json($query->get());
    }

    /**
     * Détails d'un joueur sur un pari
     */
    public function show($id)
    {
        $betPlayer = BetPlayer::with('bet.creator', 'user', 'clan')->findOrFail($id);
        return response()->json($betPlayer);
    }

    /**
     * Ajouter un joueur à un pari
     */
    public function store(Request $request)
    {
        $request->validate([
            'bet_id' => 'required|exists:bets,id',
            'user_id' => 'required|exists:users,id',
            'clan_id' => 'nullable|exists:clans,id',
        ]);

        // Vérifie que le joueur n'est pas déjà inscrit à ce pari
        $exists = BetPlayer::where('bet_id', $request->bet_id)
                           ->where('user_id', $request->user_id)
                           ->exists();

        if ($exists) {
            return response()->json(['message' => 'Le joueur est déjà inscrit à ce pari.'], 409);
        }

        $betPlayer = BetPlayer::create([
            'bet_id' => $request->bet_id,
            'user_id' => $request->user_id,
            'clan_id' => $request->clan_id,
            'status' => 'pending', // statut initial
            'result' => 'lose',    // résultat par défaut
        ]);

        return response()->json($betPlayer, 201);
    }

    /**
     * Mettre à jour le statut ou le résultat d'un joueur
     */
    public function update(Request $request, $id)
    {
        $betPlayer = BetPlayer::findOrFail($id);

        $request->validate([
            'status' => 'in:active,inactive',
            'result' => 'in:win,lose,draw'
        ]);

        $betPlayer->update($request->only('status', 'result'));

        return response()->json($betPlayer);
    }

    /**
     * Retirer un joueur d'un pari
     */
    public function destroy($id)
    {
        $betPlayer = BetPlayer::findOrFail($id);
        $betPlayer->delete();

        return response()->json(['message' => 'Joueur retiré du pari.']);
    }
}
