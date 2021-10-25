<?php

namespace app\Helpers;

use app\Helpers\CheckPermission;
use App\Model\Admin\Setting\Module;
use App\Model\Admin\Setting\WarehouseRole;
use App\Model\Admin\Setting\WarehouseAction;
use App\Model\Admin\Master\WarehouseRoleModule;
use App\Model\Admin\Setting\WarehouseRoleAction;

 

class CheckPermission{
    
    function viewAction($action){
        
        $warehouseAction = WarehouseAction::where('slug',$action)->first();  
        $allow = WarehouseRoleAction::where('role_id',auth('warehouse')->user()->role->id)->where('action_id',$warehouseAction->id)->first();
        if(!empty($allow)){
            if($allow->allow == 1){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
        // $authorization = WarehouseRoleAction::where('role_id',$role->id)->where('action_id',$warehouseAction->id)->first();
        
        // $module =   Module::where('route',$route)->first();
        // $modulePermission = WarehouseRoleModule::where('role_id',auth('warehouse')->user()->role->id)->where('module_id',$module->id)->first();
        // // if($action[0].'a' == 1){
             
        // // }else{
        //     return $modulePermission->$action == 1;
        // // }

        



    }

    public static function instance()
    {
        return new CheckPermission();
    }

    public function checkAuth($action)
    {
        $warehouseAction = WarehouseAction::where('slug',$action)->first();
        $role = WarehouseRole::find(auth('warehouse')->user()->role->id);
        $auth = WarehouseRoleAction::where('role_id',$role->id)->where('action_id',$warehouseAction->id)->first();
        if(!empty($auth)){
            if($auth->authorization == 1){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
}

?>