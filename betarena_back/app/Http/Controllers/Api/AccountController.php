<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    //Lister tous les comptes (admin seulement)
    public function index()
    {
        $accounts = Account::with('user')->get();
        return response()->json($accounts);
    }

    //Voir le compte d’un utilisateur
    public function show($id)
    {
        $account = Account::with('user')->findOrFail($id);
        return response()->json($account);
    }

    //Créer un compte (normalement auto à la création d’un user)
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id|unique:accounts,user_id',
            'pay' => 'numeric|min:0',
            'status' => 'in:active,inactive',
        ]);

        $account = Account::create([
            'user_id' => $request->user_id,
            'pay' => $request->pay ?? 0,
            'status' => $request->status ?? 'active',
        ]);

        return response()->json($account, 201);
    }

    //Déposer de l’argent sur le compte
    public function deposit(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $account = Account::findOrFail($id);

        DB::transaction(function () use ($account, $request) {
            $account->increment('pay', $request->amount);

            Transaction::create([
                'account_id' => $account->id,
                'amount' => $request->amount,
                'type' => 'deposit',
                'status' => 'completed',
            ]);
        });

        return response()->json(['message' => 'Dépôt effectué avec succès.', 'balance' => $account->pay]);
    }

    //Retirer de l’argent du compte
    public function withdraw(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $account = Account::findOrFail($id);

        if ($account->pay < $request->amount) {
            return response()->json(['message' => 'Solde insuffisant.'], 400);
        }

        DB::transaction(function () use ($account, $request) {
            $account->decrement('pay', $request->amount);

            Transaction::create([
                'account_id' => $account->id,
                'amount' => $request->amount,
                'type' => 'withdraw',
                'status' => 'completed',
            ]);
        });

        return response()->json(['message' => 'Retrait effectué avec succès.', 'balance' => $account->pay]);
    }

    //Transferer de l’argent entre comptes
    public function transfer(Request $request, $fromId)
    {
        $request->validate([
            'to_account_id' => 'required|exists:accounts,id|different:fromId',
            'amount' => 'required|numeric|min:1',
        ]);

        $fromAccount = Account::findOrFail($fromId);
        $toAccount = Account::findOrFail($request->to_account_id);

        if ($fromAccount->pay < $request->amount) {
            return response()->json([
                'message' => 'Solde insuffisant pour effectuer le transfert.'
            ], 400);
        }

        \DB::transaction(function () use ($fromAccount, $toAccount, $request) {
            $fromAccount->decrement('pay', $request->amount);

            $toAccount->increment('pay', $request->amount);

            Transaction::create([
                'account_id'   => $fromAccount->id,
                'to_account_id'=> $toAccount->id,
                'amount'       => $request->amount,
                'type'         => 'transfer',
                'status'       => 'completed',
            ]);
        });

        return response()->json([
            'message' => 'Transfert effectué avec succès.',
            'from_account' => $fromAccount->fresh(),
            'to_account' => $toAccount->fresh(),
        ]);
    }

    //Mettre à jour le statut du compte
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:active,inactive',
        ]);

        $account = Account::findOrFail($id);
        $account->update(['status' => $request->status]);

        return response()->json(['message' => 'Statut du compte mis à jour.', 'status' => $account->status]);
    }

    //Voir le solde du compte connecté
    public function myBalance(Request $request)
    {
        $account = Account::where('user_id', $request->user()->id)->firstOrFail();
        return response()->json(['balance' => $account->pay]);
    }

    //Supprimer un compte
    public function destroy($id)
    {
        $account = Account::findOrFail($id);
        $account->delete();

        return response()->json(['message' => 'Compte supprimé.']);
    }
}
