<?php

namespace App\Model\Admin\Setting;

use Illuminate\Database\Eloquent\Model;
use App\Model\Admin\Setting\WarehouseRole;
use App\Model\Admin\Setting\WarehouseAction;

class WarehouseRoleAction extends Model
{
   protected $table = "warehouse_role_actions";

   protected $fillable = ['role_id','action_id','allow','authorization'];

   public function warehouseRole(){
       
    return $this->belongsTo(WarehouseRole::class,'role_id','id');
        
   }

   public function action(){
      return $this->belongsTo(WarehouseAction::class,'action_id','id');
   }


}
