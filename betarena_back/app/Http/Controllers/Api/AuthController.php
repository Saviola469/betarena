<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;


class AuthController extends Controller
{

    // Enregistrement
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'pseudo' => 'required|string|max:50|unique:users,pseudo',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'in:admin,player,maintainer' // optionnel, sinon 'player' par défaut
        ]);

        $user = User::create([
            'name' => $request->name,
            'pseudo' => $request->pseudo,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role ?? 'player',
        ]);

        // Créer automatiquement un compte lié
        Account::create([
            'user_id' => $user->id,
            'pay' => 0,
            'status' => 'active',
        ]);

        // Envoi de l'email de vérification
        event(new Registered($user));

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
            'message' => 'Vérifiez votre email pour activer votre compte.'
        ], 201);
    }

    // Connexion

    protected function maxAttempts()
    {
        return 3; // après 3 échecs
    }

    protected function decayMinutes()
    {
        return 2; // bloqué 2 minutes
    }
    
    protected function username()
    {
        return 'identifiant'; // car tu valides "identifiant" dans ton login
    }
    
    public function login(Request $request)
    {
        $request->validate([
            'identifiant' => 'required|string',
            'password' => 'required|string',
        ]);

        // Cherche l'utilisateur par email ou pseudo
        $user = User::where('email', $request->identifiant)
            ->orWhere('pseudo', $request->identifiant)
            ->first();

        // Vérifie le mot de passe
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Identifiants invalides'], 401);
        }

        // Crée un token si login réussi
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'account' => $user->account,
            'token' => $token,
        ]);
    }

    // Déconnexion
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    }

    // Utilisateur connecté
    public function me(Request $request)
    {
        return response()->json($request->user());
    }
    
}
