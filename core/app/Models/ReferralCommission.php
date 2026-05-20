<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReferralCommission extends Model
{
    protected $guarded = [];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    public function earner()
    {
        return $this->belongsTo(User::class, 'earner_user_id');
    }

    public function sourceUser()
    {
        return $this->belongsTo(User::class, 'source_user_id');
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function investment()
    {
        return $this->belongsTo(Investment::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
