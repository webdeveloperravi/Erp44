<?php

namespace App\Model\Admin\Organization;

use Illuminate\Database\Eloquent\Model;

class ConversionType extends Model
{
   

     protected $fillable=['name','status'];
     protected $table="conversion_type";


}
