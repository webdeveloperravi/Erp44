<?php

namespace App\Model\Admin\Setting;

use App\Model\Admin\Setting\Module;
use Illuminate\Database\Eloquent\Model;
use App\Model\Admin\Setting\WarehouseRole;
use App\Model\Admin\Setting\WarehouseAction;
use App\Model\Admin\Setting\WarehouseRoleAction;

class WarehouseAction extends Model
{
  protected $table ='warehouse_actions';
  protected $guarded = [''];
  public $timestamps = false;

  public function warehouseRoles(){

    return $this->belongsToMany(WarehouseRole::class,'warehouse_role_actions','role_id','action_id')->withPivot('allow','authorization');
  }

  public function warehouseRoleActions(){
    return $this->hasMany(WarehouseRoleAction::class,'action_id','id');
 }

 public function actionType(){
   return $this->brlongsTo(WarehouseAction::class,'action_id','id');
 }
 public function actions(){

 	return $this->hasMany(WarehouseAction::class,'parent','id');
 }

 public function module(){
   return $this->belongsTo(Module::class,'module_id','id');
 }

}
