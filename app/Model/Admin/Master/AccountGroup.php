<?php

namespace App\Model\Admin\Master;

use Illuminate\Database\Eloquent\Model;
use App\Model\Admin\Master\AccountGroup;
use App\Model\Guard\UserStore;

class AccountGroup extends Model
{
    
      protected $guarded =[""];
      protected $table="account_groups";
 
    
    public function subGroups()
    {
    	return $this->hasMany(AccountGroup::class,"parent_id",'id');
    }
    
    public function store(){
      return $this->hasMany(UserStore::class,'account_group_id','id');
    }



}
