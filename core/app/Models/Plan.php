<?php

namespace App\Models;

use App\Traits\GlobalStatus;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use GlobalStatus;

    public function referralRules()
    {
        return $this->hasMany(Referral::class);
    }
    
}
