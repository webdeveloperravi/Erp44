<?php

namespace App\Model\Admin\Master;

use Illuminate\Database\Eloquent\Model;

class Culet extends Model
{
    protected $guarded = [''];
    public $table ='culets';

    public function masterIds()
    {
        return $this->morphMany(MasterCreateUpdate::class, 'masterable');
    }

    
    public function getCreatedByName(){
  
        return $this->belongsTo(UserAdmin::class,'created_id','id');
  
      }
      

}
