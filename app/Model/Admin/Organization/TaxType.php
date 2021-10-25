<?php

namespace App\Model\Admin\Organization;

use Illuminate\Database\Eloquent\Model;
use App\Model\Admin\Organization\OrgRole;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\Admin\Master\MasterCreateUpdate;
use App\Model\Admin\Organization\StoreAddress;


class TaxType extends Model
{
   
     use SoftDeletes;
     protected $fillable=['name','status'];
     protected $table="org_tax_type";

     public function masterIds()
     {
         return $this->morphMany(MasterCreateUpdate::class, 'masterable');
     }  


  public function AssignTaxRate(){

     	return $this->hasOne('App\Model\Admin\Organization\TaxRate','org_tax_type_id');
     }
  //  public function org_roles()
  //   {
    
  //   return $this->morphToMany('App\Model\Admin\Organization\OrgRole', 'org_role_configables');
  
  //   }

    public function orgRole(){
  return $this->hasOne(OrgRole::class,'tex_type_id','id');
}

public function storeAddresses()
{
    return $this->hasMany(StoreAddress::class,'tax_type_id','id');
}



}
