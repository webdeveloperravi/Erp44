<?php

namespace App\Model;

use App\Model\Guard\UserStore;
use Illuminate\Database\Eloquent\Model;

class SecurityPinRegenerateRequest extends Model
{
    protected $guarded = [''];

    public function securityPinRegenerateRequestable(){
        return $this->morphTo('security_pin_regenerate_requests','requestable_type','requestable_id');
    }

    public function resolvedBy()
    {
        return $this->belongsTo(UserStore::class,'resolved_by','id');
    }
}
