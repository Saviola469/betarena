<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    // GET /api/leaderboard
    public function index(Request $request)
    {
        $users = User::with('badges')
            ->orderByDesc('score')
            ->paginate(20);
        return response()->json($users);
    }

    // GET /api/leaderboard/{user_id}
    public function show($user_id)
    {
        $user = User::with('badges')->findOrFail($user_id);
        return response()->json($user);
    }
}
