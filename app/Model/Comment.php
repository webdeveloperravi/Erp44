<?php

namespace App\Model;

use App\Model\Guard\UserStore;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    protected $guarded =[''];

    public function commentable(){
        return $this->morphTo();
    }

    public function user(){
        return $this->belongsTo(UserStore::class,'store_user_id','id');
    }
}
