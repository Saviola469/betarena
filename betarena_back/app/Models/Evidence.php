<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evidence extends Model
{
    protected $fillable = ['bet_id','type','file_path'];
    public function bet() { return $this->belongsTo(Bet::class); }
}
