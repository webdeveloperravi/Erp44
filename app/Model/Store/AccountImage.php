<?php

namespace App\Model\Store;

use Illuminate\Database\Eloquent\Model;
use App\Model\Guard\UserStore;

class AccountImage extends Model
{
      protected $guarded =[''];
    
   public function imageable()
    {
        return $this->morphTo();
    }

      public function user(){
        return $this->belongsTo(UserStore::class,'store_user_id','id');
    }
}
