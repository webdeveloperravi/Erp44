<?php

namespace App\Model\Admin\Setting;

use App\Model\Guard\UserStore;
use App\Model\Store\ManagerRole;
use App\Model\Store\OrgRoleModule;
use Illuminate\Support\Collection;
use App\Model\Store\ManagerRoleModule;
use Illuminate\Database\Eloquent\Model;
use App\Model\Admin\Organization\OrgRole;
use App\Model\Admin\Setting\WarehouseAction;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\Admin\Master\MasterCreateUpdate;

class Module extends Model
{
    
    use SoftDeletes;

   // protected $fillable=['title','route','guard_id', 'parent','parent_sort','child_sort', 'created_by', 'status'];
  
   protected $guarded =[''];
    protected $table="modules";

    public function masterIds()
    {
        return $this->morphMany(MasterCreateUpdate::class, 'masterable');
    }


   // many to many relationship . its user org_role name and module names.
   
   public function orgRoles(){
    
    return $this->belongsToMany(OrgRole::class,'org_role_module','role_id','module_id');

   } 

    public function sub_module(){

       return $this->hasMany('App\Model\Admin\Setting\Module','parent','id')->orderBy('child_sort','asc');
    }

    public function parent()
    {
        return $this->belongsToOne(Module::class, 'parent', 'id');
    }

    public function getAllParents()
    {
        $parents = collect([]);
        $parent = $this->parent;

        while(!is_null($parent) && $parent != 0) { 
            $parents->push($parent);
            $parent = Module::find($parent) ?? false;
            $parent = $parent->parent != 0 ? $parent->parent : null;
        }
        return $parents;
    }

    public function assign_guard(){

    	return $this->belongsTo('App\Model\Admin\Setting\Guard','guard_id');
    }
 

    public function warehouseRoles(){

        return $this->belongsToMany('App\Model\Admin\Setting\WarehouseRole','warehouse_role_module','role_id','module_id')->withPivot('create','read','update','delete');
    }

    public function actions(){
        return $this->hasMany(WarehouseAction::class,'module_id','id');
    }

    public function store(){
        return $this->belongsTo(UserStore::class,'guard_id','guard_id');
    }

    public function managerRoles(){
        return $this->belongsToMany(ManagerRole::class,'store_user_role_module','role_id','module_id');
    }
 

    public function getCreateManager($roleId,$moduleId){
         
        $create = ManagerRoleModule::where(['role_id'=>$roleId,'module_id'=>$moduleId])->first();
     
        if($create){ 
            return $create->c == '1' ? '1' : '0';
        }else{
            return '0';
        }
    }

    public function getReadManager($roleId,$moduleId){
        $read = ManagerRoleModule::where(['role_id'=>$roleId,'module_id'=>$moduleId])->first();
        if($read){
            return $read->r == '1' ? '1' : '0';
        }else{
            return '0';
        }
    }

    public function getUpdateManager($roleId,$moduleId){
        $update = ManagerRoleModule::where(['role_id'=>$roleId,'module_id'=>$moduleId])->first();
        if($update){
            return $update->u == '1' ? '1' : '0';
        }else{
            return '0';
        }
    }

    public function getDeleteManager($roleId,$moduleId){
        $delete = ManagerRoleModule::where(['role_id'=>$roleId,'module_id'=>$moduleId])->first();
        if($delete){
            return $delete->d == '1' ? '1' : '0';
        }else{
            return '0';
        }
    }
 

    public function getCreateOrg($roleId,$moduleId){
         
        $create = OrgRoleModule::where(['role_id'=>$roleId,'module_id'=>$moduleId])->first();
     
        if($create){ 
            return $create->c == '1' ? '1' : '0';
        }else{
            return '0';
        }
    }

    public function getReadOrg($roleId,$moduleId){
        $read = OrgRoleModule::where(['role_id'=>$roleId,'module_id'=>$moduleId])->first();
        if($read){
            return $read->r == '1' ? '1' : '0';
        }else{
            return '0';
        }
    }

    public function getUpdateOrg($roleId,$moduleId){
        $update = OrgRoleModule::where(['role_id'=>$roleId,'module_id'=>$moduleId])->first();
        if($update){
            return $update->u == '1' ? '1' : '0';
        }else{
            return '0';
        }
    }

    public function getDeleteOrg($roleId,$moduleId){
        $delete = OrgRoleModule::where(['role_id'=>$roleId,'module_id'=>$moduleId])->first();
        if($delete){
            return $delete->d == '1' ? '1' : '0';
        }else{
            return '0';
        }
    }
 

    public function getCreateAdmin($roleId,$moduleId){
         
        $create = AdminRoleModule::where(['role_id'=>$roleId,'module_id'=>$moduleId])->first();
     
        if($create){ 
            return $create->c == '1' ? '1' : '0';
        }else{
            return '0';
        }
    }

    public function getReadAdmin($roleId,$moduleId){
        $read = AdminRoleModule::where(['role_id'=>$roleId,'module_id'=>$moduleId])->first();
        if($read){
            return $read->r == '1' ? '1' : '0';
        }else{
            return '0';
        }
    }

    public function getUpdateAdmin($roleId,$moduleId){
        $update = AdminRoleModule::where(['role_id'=>$roleId,'module_id'=>$moduleId])->first();
        if($update){
            return $update->u == '1' ? '1' : '0';
        }else{
            return '0';
        }
    }

    public function getDeleteAdmin($roleId,$moduleId){
        $delete = AdminRoleModule::where(['role_id'=>$roleId,'module_id'=>$moduleId])->first();
        if($delete){
            return $delete->d == '1' ? '1' : '0';
        }else{
            return '0';
        }
    }

     

}
