<?php

namespace App\Model\Admin;

use App\Model\Guard\UserStore;
use Illuminate\Database\Eloquent\Model;

class WhiteListIpAddress extends Model
{
    protected $guarded = [''];

    public $table = 'whitelist_ip_addresses';

    public function store()
    {
        return $this->belongsTo(UserStore::class,'store_id','id');
    }

    public function managers()
    {
        return $this->belongsToMany(UserStore::class,'user_store_ip_addresses','ip_address_id','user_store_id');
    }

    
}
