<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['account_id','amount', 'to_account_id', 'type','status','failed_reason'];
    public function account() { return $this->belongsTo(Account::class); }
    public function toAccount() { return $this->belongsTo(Account::class, 'to_account_id'); }
}
