<?php

namespace App\Model\Admin\Setting;

use Illuminate\Database\Eloquent\Model; 
use App\Model\Admin\Setting\AdminAction;
use App\Model\Admin\Setting\AdminRoleAction;

class AdminRole extends Model
{   
	protected $guarded = [''];
    protected $table ="admin_roles";

    public function subRoles()
    {
    	return $this->hasMany("App\Model\Admin\Setting\AdminRole","parent_id",'id');
    }

    public function role()
    {
    	return $this->belongsTo("App\Model\Admin\Setting\AdminRole","parent_id",'id');
    }

    public function adminModules(){

        return $this->belongsToMany('App\Model\Admin\Setting\Module','admin_role_module','role_id','module_id')->withPivot('create','read','delete','update','ca','ra','ua','da');
    }

    public function modules(){

        return $this->belongsToMany('App\Model\Admin\Setting\Module','admin_role_module','role_id','module_id')->withPivot('create','read','delete','update','ca','ra','ua','da');
    }

    public function users(){

        return $this->hasMany("App\Model\Admin\Guard\UserAdmin",'role_id','id');
    }
 
}
