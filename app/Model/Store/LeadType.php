<?php

namespace App\Model\Store;

use App\Model\Store\Lead;
use Illuminate\Database\Eloquent\Model;

class LeadType extends Model
{
   public function lead(){
       return hasMany(Lead::class,'lead_type_id','id');
   }
}
