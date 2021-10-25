<?php

namespace App\Model\Admin\Setting;

use Illuminate\Database\Eloquent\Model;

class WarehouseActionType extends Model
{
    protected $table = 'warehouse_action_type';

    public function actions(){
        return $this->hasMany(WarehouseAction::class,'action_id','id');
    }
}
