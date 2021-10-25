<?php

namespace App\Model\Store;

use Illuminate\Support\Collection;
use App\Model\Admin\Setting\Module;
use Illuminate\Database\Eloquent\Model;
use App\Model\Store\ManagerRole;

class ManagerRole extends Model
{
   protected $guarded=[];
   protected $table ='store_user_roles';

   
  public function subRoles(){
    return $this->hasMany(ManagerRole::class,'parent_id','id');
  }   

  public function modules(){
    return $this->belongsToMany(Module::class,'store_user_role_module','role_id','module_id')->withPivot('c','r','u','d')->orderBy('parent_sort');
  }

  public function manager(){

    return $this->hasOne('App\Model\Guard\UserStore','manager_role_id','id');
    
  }

  public function getAllChildren ()
  {
      $sections = new Collection();

      foreach ($this->subRoles as $section) {
          $sections->push($section->id);
          $sections = $sections->merge($section->getAllChildren());
      }

      return $sections->toArray();
  }

  public function store()
  {
    return $this->belongsTo(UserStore::Class,'store_id','id');
  }


}
