<?php

namespace App\Model\Admin\Master;

use Illuminate\Database\Eloquent\Model;
use App\Model\Admin\Master\MasterCreateUpdate;

class Symmetry extends Model
{
    protected $guarded = [''];
    protected  $table  ='symmetries';

    public function masterIds()
    {
        return $this->morphMany(MasterCreateUpdate::class, 'masterable');
    }



    public function getCreatedByName(){
  
        return $this->belongsTo(UserAdmin::class,'created_id','id');
  
      }

}
