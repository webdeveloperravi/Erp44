<?php

namespace App\Model\Store;

use Illuminate\Database\Eloquent\Model;
use App\Model\Guard\UserStore;

class AccountComment extends Model
{
    
    protected $table = 'comments';

    protected $guarded =[''];
    

    public function commentable()
    {
        return $this->morphTo();
    }

      public function user(){
        return $this->belongsTo(UserStore::class,'store_user_id','id');
    }

}
