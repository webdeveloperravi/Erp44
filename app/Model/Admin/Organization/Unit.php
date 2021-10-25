<?php

namespace App\Model\Admin\Organization;
 
use App\Model\Warehouse\InvoiceDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\Admin\Master\MasterCreateUpdate;
use App\Model\Admin\Organization\UnitConversion;

class Unit extends Model
{
    
     use SoftDeletes;
     protected $fillable=['name','alias','description','uqc','status'];
     protected $table="units";

  //  public function org_roles()
  //   {
    
  //   return $this->morphToMany('App\Model\Admin\Organization\OrgRole', 'org_role_configable');
  
  //   }

  public function masterIds()
     {
         return $this->morphMany(MasterCreateUpdate::class, 'masterable');
     }  

    public function unitConversion(){

      return $this->hasOne(UnitConversion::Class,'unit_main_id','id');
    }
    
    public function invoiceDetail(){

      return $this->hasMany(InvoiceDetail::Class,'unit_id','id');
    }

    public function orgRole(){
      return $this->hasOne(OrgRole::class,'unit_id','id');
    }

}
