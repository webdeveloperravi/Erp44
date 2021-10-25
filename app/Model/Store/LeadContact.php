<?php

namespace App\Model\Store;
 
use App\Model\Store\Lead;
use Illuminate\Database\Eloquent\Model;

class LeadContact extends Model
{
   
      protected $guarded = [''];


      public function lead(){
            
             return $this->belongsTo(Lead::class,'lead_id','id');
      }

      



}
