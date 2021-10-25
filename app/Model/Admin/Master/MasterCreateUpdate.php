<?php

namespace App\Model\Admin\Master;
use App\Model\Guard\UserAdmin;
use App\Model\Admin\Master\ProductMColour;

use Illuminate\Database\Eloquent\Model;

class MasterCreateUpdate extends Model
{
    protected $guarded = [''];
    public $table ='master_create_updateables';
    
    public function masterAble()
    {
        return $this->morphTo('masterIds','masterable_id','masterable_type');
    }

    public function getCreatedById(){
        return $this->belongsTo(UserAdmin::class,'created_id','id');
    }

    public function getUpdatedId(){
        return $this->belongsTo(UserAdmin::class,'updated_id','id');
    }

    public function colors(){
        return $this->belongsTo(ProductMColour::class,'masterable_id','id');  
    }


}
