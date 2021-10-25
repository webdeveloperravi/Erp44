<?php

namespace App\Model\Store;

use App\Model\Guard\UserStore;
use Illuminate\Database\Eloquent\Model;

class Cash extends Model
{
   protected $table = 'user_store';
   protected $guarded = [''];

   public function store(){
       return $this->belongsTo(UserStore::class,'org_id','id');
   }
}
