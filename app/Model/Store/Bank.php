<?php

namespace App\Model\Store;

use Illuminate\Database\Eloquent\Model;
use App\Model\Guard\UserStore;

class Bank extends Model
{
    protected $guarded = [''];
    protected $table ="user_store";

    public function store()
    {
    	return $this->belongsTo(UserStore::class,'org_id','id');
    }

}
