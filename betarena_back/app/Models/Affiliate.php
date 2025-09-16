<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Affiliate extends Model
{
    protected $fillable = [
        'user_id', 'rank', 'progression', 'total_gains', 'current_month_gains'
    ];

    public function user() { return $this->belongsTo(User::class); }
    public function referrals() { return $this->hasMany(Referral::class, 'referrer_id', 'user_id'); }
}
