<?php

namespace App\Model\Store;

use App\Model\Store\Lead;
use Illuminate\Database\Eloquent\Model;

class LeadStatus extends Model
{
   public function lead(){
       return hasMany(Lead::class,'lead_status_id','id');
   }
}
