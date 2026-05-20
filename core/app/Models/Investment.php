<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    use  GlobalStatus;

    protected $casts = [
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function plan(){
        return $this->hasOne(Plan::class, 'id', 'plan_id');
    }

    public function statusBadge(): Attribute
    {
        return new Attribute(
            get:fn () => $this->badgeData(),
        );
    }

    public function badgeData(){
        $html = '';
        if($this->status == Status::INVESTMENT_PENDING){
            $html = '<span class="badge badge--warning">'.trans("Pending Approval").'</span>';
        }
        elseif($this->status == Status::RUNNING){
            $html = '<span class="badge badge--success">'.trans("Running").'</span>';
        }
        elseif($this->status == Status::COMPLETED){
            $html = '<span class="badge badge--warning">'.trans("Completed").'</span>';
        }
        elseif($this->status == Status::INVESTMENT_REJECTED){
            $html = '<span class="badge badge--danger">'.trans("Rejected").'</span>';
        }

       
        return $html;
    }

}
