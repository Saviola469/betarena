<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\Api\BetController;
use App\Http\Controllers\Api\BetPlayerController;
use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Api\TournamentController;
use App\Http\Controllers\Api\ClanController;
use App\Http\Controllers\Api\AffiliateController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\GroupConversationController;
use App\Http\Controllers\Api\LeaderboardController;


// Route pour tester l'utilisateur connecté (authentifié)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Routes publiques
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');

// Routes protégées (authentification requise)
Route::middleware('auth:sanctum')->group(function () {
    // Déconnexion
    Route::post('/logout', [AuthController::class, 'logout']);

    // Infos du compte connecté
    Route::get('/me', [AuthController::class, 'me']);

    // Vérification email via lien
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill(); // met à jour email_verified_at
        return response()->json(['message' => 'Email vérifié avec succès !']);
    })->name('verification.verify');

    // Renvoi du mail de vérification
    Route::post('/email/resend', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return response()->json(['message' => 'Email de vérification renvoyé.']);
    })->name('verification.send');
});


Route::middleware(['auth:sanctum','verified'])->group(function() {
    Route::get('/bets', [BetController::class,'index']);
    Route::get('/bets/{id}', [BetController::class,'show']);
    Route::post('/bets', [BetController::class,'store']);
    Route::patch('/bets/{id}', [BetController::class,'update']);
    Route::delete('/bets/{id}', [BetController::class,'destroy']);

    // Rejoindre un pari
    Route::post('/bets/{id}/join', [BetController::class, 'join']);

    // Historique des paris de l'utilisateur connecté
    Route::get('/bets/history', [BetController::class, 'history']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('bet-players', BetPlayerController::class);
});

//Comptes
Route::middleware(['auth:sanctum','verified'])->prefix('accounts')->group(function () {
    // Lister tous les comptes (admin a faire)
    Route::get('/', [AccountController::class, 'index']);

    Route::get('/{id}', [AccountController::class, 'show']);
    Route::post('/', [AccountController::class, 'store']);
    Route::post('/{id}/deposit', [AccountController::class, 'deposit']);
    Route::post('/{id}/withdraw', [AccountController::class, 'withdraw']);
    Route::post('/{id}/transfer', [AccountController::class, 'transfer']);
    Route::get('/me/balance', [AccountController::class, 'myBalance']);
    Route::patch('/{id}/status', [AccountController::class, 'updateStatus']);
    Route::delete('/{id}', [AccountController::class, 'destroy']);
});

// Tournois
Route::middleware(['auth:sanctum','verified'])->group(function() {
    Route::get('/tournaments', [TournamentController::class, 'index']);
    Route::post('/tournaments', [TournamentController::class, 'store']);
    Route::get('/tournaments/{id}', [TournamentController::class, 'show']);
    Route::post('/tournaments/{id}/register', [TournamentController::class, 'register']);
});

// Clans
Route::middleware(['auth:sanctum','verified'])->group(function() {
    Route::get('/clans', [ClanController::class, 'index']);
    Route::post('/clans', [ClanController::class, 'store']);
    Route::get('/clans/{id}', [ClanController::class, 'show']);
    Route::post('/clans/{id}/join', [ClanController::class, 'join']);
});

// Affiliation
Route::middleware(['auth:sanctum','verified'])->group(function() {
    Route::get('/affiliate', [AffiliateController::class, 'index']);
    Route::get('/affiliate/invite-link', [AffiliateController::class, 'inviteLink']);
    Route::get('/affiliate/referrals', [AffiliateController::class, 'referrals']);
});

// Messages
Route::middleware(['auth:sanctum','verified'])->group(function() {
    Route::get('/messages/conversations', [MessageController::class, 'conversations']);
    Route::get('/messages/{conversation_id}', [MessageController::class, 'messages']);
    Route::post('/messages/{conversation_id}', [MessageController::class, 'send']);
});

// Conversations de groupe (clan)
Route::middleware(['auth:sanctum','verified'])->group(function() {
    Route::get('/clans/{clan_id}/group-conversation', [GroupConversationController::class, 'show']);
    Route::post('/clans/{clan_id}/group-conversation', [GroupConversationController::class, 'send']);
});

// Classement (Leaderboard)
Route::get('/leaderboard', [LeaderboardController::class, 'index']);
Route::get('/leaderboard/{user_id}', [LeaderboardController::class, 'show']);

// Profil utilisateur
Route::middleware(['auth:sanctum','verified'])->group(function() {
    Route::get('/profile', [\App\Http\Controllers\Api\ProfileController::class, 'show']);
    Route::get('/profile/bets', [\App\Http\Controllers\Api\ProfileController::class, 'bets']);
    Route::get('/profile/badges', [\App\Http\Controllers\Api\ProfileController::class, 'badges']);
});

