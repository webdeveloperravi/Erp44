<?php

namespace App\Model\Store;

use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
     protected $guarded=[];

     protected $table ="store_users";

     public function managerRoles(){

     	return $this->belongsTo(ManagerRole::Class,'role_id','id');
     }

     public function stores(){
     	return $this->belongsTo('App\Model\Guard\UserStore','store_id','id');
     }

     public function setNameAttribute($value)
     {
         $this->attributes['name'] = ucwords($value);
     }
}
