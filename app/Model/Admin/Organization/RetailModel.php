<?php

namespace App\Model\Admin\Organization;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Model\Admin\Organization\OrgRole;
use App\Model\Admin\Master\MasterCreateUpdate;
use App\Model\Admin\Organization\DiscountRate;

class RetailModel extends Model
{
       protected $fillable=['name','alias','description','retail_type_id','parent_id','discount_id','created_by','status'];
       protected $table="retail_model";
    
       public function masterIds()
       {
           return $this->morphMany(MasterCreateUpdate::class, 'masterable');
       }
      

      public function subRetailModels()
      {
           return $this->hasMany("App\Model\Admin\Organization\RetailModel","parent_id",'id');
      }
       

       

  public function getAllChildren ()
  {
      $sections = new Collection();

      foreach ($this->subRetailModels as $section) {
          $sections->push($section->id);
          $sections = $sections->merge($section->getAllChildren());
      }

      return $sections->toArray();
  }

       public function retailType(){
   
        return $this->belongsTo('App\Model\Admin\Organization\RetailType','retail_type_id','id');

       }

       public function retailModel(){
  
         return $this->hasOne('App\Model\Admin\Organization\RetailModel','parent_id','id');
 
       }

       public function discount(){
   
          return $this->belongsTo(DiscountRate::class,'discount_id','id');
       }
      
       
//  public function org_roles()
//  {
// return $this->morphToMany(OrgRole::class, 'org_role_configable');
// }
  
public function orgRole(){
  return $this->hasmany(OrgRole::class,'retail_model_id','id');
}

}
