<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Affiliate;
use App\Models\Referral;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AffiliateController extends Controller
{
    // Stats et progression du programme d'affiliation
    public function index(Request $request)
    {
        $user = $request->user();
        $affiliate = Affiliate::with('referrals')->where('user_id', $user->id)->first();
        return response()->json($affiliate);
    }

    // Générer le lien d'invitation unique
    public function inviteLink(Request $request)
    {
        $user = $request->user();
        $link = url('/invite/' . Str::slug($user->name) . '-' . $user->id);
        return response()->json(['invite_link' => $link]);
    }

    // Liste des parrainages
    public function referrals(Request $request)
    {
        $user = $request->user();
        $referrals = Referral::with('referred')->where('referrer_id', $user->id)->orderByDesc('date')->get();
        return response()->json($referrals);
    }
}
