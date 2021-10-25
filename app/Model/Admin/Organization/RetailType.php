<?php

namespace App\Model\Admin\Organization;

use Illuminate\Database\Eloquent\Model;

class RetailType extends Model
{
     protected $fillable=['name','alias','descriptioin'];
       protected $table="retail_types";

     public function retailModel(){
         
         return $this->belongsTo('App\Model\Admin\Organization\retailModel','retail_type_id','id');

     }


}
