<?php

namespace App\Http\Controllers;

use App\Models\Bet;
use App\Models\Matchs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BetController extends Controller
{
    // Liste tous les paris avec filtres et pagination
    public function index(Request $request)
    {
        $query = Bet::with('players','creator','match');

        // Filtres avancés
        if ($request->has('user_id')) {
            $query->where('created_by', $request->user_id);
        }
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }
        if ($request->has('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Pagination
        $perPage = $request->get('per_page', 10);
        $bets = $query->paginate($perPage);
        return response()->json($bets);
    }

    // Affiche un pari spécifique
    public function show($id)
    {
        $bet = Bet::with('players','creator','match','evidences')->findOrFail($id);
        return response()->json($bet);
    }

    // Créer un pari
    public function store(Request $request)
    {
        $request->validate([
            'match_id' => 'required|exists:matchs,id',
            'type' => 'required|string',
            'stake' => 'required|numeric|min:0',
            'is_clanBet' => 'boolean'
        ]);

        $bet = Bet::create([
            'created_by' => Auth::id(),
            'match_id' => $request->match_id,
            'type' => $request->type,
            'stake' => $request->stake,
            'is_clanBet' => $request->is_clanBet ?? false,
        ]);

        return response()->json($bet, 201);
    }

    // Mettre à jour un pari (ex: accepter/refuser, changer status)
    public function update(Request $request, $id)
    {
        $bet = Bet::findOrFail($id);

        $request->validate([
            'status' => 'in:planned,accepted,in_progress,finished',
        ]);

        if ($request->has('status')) {
            $bet->status = $request->status;
        }

        $bet->save();

        return response()->json($bet);
    }

    // Rejoindre un pari
    public function join(Request $request, $id)
    {
        $bet = Bet::findOrFail($id);
        $user = $request->user();

        // Vérifie que le joueur n'est pas déjà inscrit à ce pari
        $exists = $bet->players()->where('user_id', $user->id)->exists();
        if ($exists) {
            return response()->json(['message' => 'Vous êtes déjà inscrit à ce pari.'], 409);
        }

        $betPlayer = $bet->players()->create([
            'user_id' => $user->id,
            'status' => 'pending',
            'result' => 'lose',
        ]);

        return response()->json($betPlayer, 201);
    }

    // Historique des paris de l'utilisateur connecté
    public function history(Request $request)
    {
        $user = $request->user();
        $bets = Bet::with('players','creator','match')
            ->where('created_by', $user->id)
            ->orWhereHas('players', function($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->orderByDesc('created_at')
            ->paginate($request->get('per_page', 10));
        return response()->json($bets);
    }

    // Supprimer un pari
    public function destroy($id)
    {
        $bet = Bet::findOrFail($id);
        $bet->delete();

        return response()->json(['message' => 'Bet supprimé']);
    }
}
