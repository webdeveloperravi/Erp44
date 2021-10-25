<?php

namespace App\Model\Admin\Organization;

use App\Model\Store\Ledger;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\Admin\Master\MasterCreateUpdate;

class DiscountRate extends Model
{
    

     use SoftDeletes;
     protected $fillable=['name','rate','status'];
     protected $table="org_discount_rate";

    public function masterIds()
    {
        return $this->morphMany(MasterCreateUpdate::class, 'masterable');
    }

 
 public function org_roles()
    {
   return $this->morphToMany('App\Model\Admin\Organization\OrgRole', 'org_role_configable');
  }

  public function ledger(){
     $this->hasMany(Ledger::class,'discount_rate_id','id');
  }





}
