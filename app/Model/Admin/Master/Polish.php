<?php

namespace App\Model\Admin\Master;

use App\Model\Guard\UserAdmin;
use Illuminate\Database\Eloquent\Model;

class Polish extends Model
{

    protected $guarded = [''];
    protected  $table  = 'polishs';
  
    public function masterIds()
    {
        return $this->morphMany(MasterCreateUpdate::class, 'masterable');
    }


    public function getCreatedByName(){
  
      return $this->belongsTo(UserAdmin::class,'created_id','id');

    }
    




}
