<?php

namespace App\Model\Admin\Setting;

use Illuminate\Database\Eloquent\Model; 
use App\Model\Admin\Setting\WarehouseAction;
use App\Model\Admin\Setting\WarehouseRoleAction;

class WarehouseRole extends Model
{   
	protected $fillable = ['guard_id','name','alias','parent_id','status'];
    protected $table ="warehouse_roles";

    public function subRoles()
    {
    	return $this->hasMany("App\Model\Admin\Setting\WarehouseRole","parent_id",'id');
    }

    public function role()
    {
    	return $this->belongsTo("App\Model\Admin\Setting\WarehouseRole","parent_id",'id');
    }

    public function warehouseModules(){

        return $this->belongsToMany('App\Model\Admin\Setting\Module','warehouse_role_module','role_id','module_id')->withPivot('create','read','delete','update','ca','ra','ua','da');
    }

    public function modules(){

        return $this->belongsToMany('App\Model\Admin\Setting\Module','warehouse_role_module','role_id','module_id')->withPivot('create','read','delete','update','ca','ra','ua','da');
    }

    public function users(){

        return $this->hasMany("App\Model\Admin\Guard\UserWarehouse",'role_id','id');
    }

    public function warehouseRoleActions(){

        return $this->belongsToMany(WarehouseAction::class,'warehouse_role_actions','role_id','action_id')->withPivot('allow','authorization');
    }
 





    

     
}
