<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // GET /api/profile : infos + stats
    public function show()
    {
        $user = Auth::user();
        $user->load('badges');
        // Ajoute ici les stats calculées si besoin
        return response()->json($user);
    }

    // GET /api/profile/bets : historique des paris
    public function bets()
    {
        $user = Auth::user();
        $bets = $user->betsCreated()->with('betPlayers')->orderByDesc('created_at')->get();
        return response()->json($bets);
    }

    // GET /api/profile/badges : badges
    public function badges()
    {
        $user = Auth::user();
        $badges = $user->badges;
        return response()->json($badges);
    }
}
