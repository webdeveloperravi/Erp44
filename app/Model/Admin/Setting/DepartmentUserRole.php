<?php

namespace App\Model\Admin\Setting;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DepartmentUserRole extends Model
{
     
      use SoftDeletes;
      protected $fillable=['id', 'guard_id', 'name','status','created_by'];
      protected $table="warehouse_roles"; 

     public function configAssignGuard(){

     	 return $this->belongsTo('App\Model\Admin\Setting\Guard','guard_id');
     }
  


   

     


}
