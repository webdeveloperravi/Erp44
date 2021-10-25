<?php

namespace App\Model\Admin\Master;

use App\Model\Admin\Master\HSNCode;
use Illuminate\Database\Eloquent\Model;
use App\Model\Admin\Organization\TaxRate;


class AssignHsnCodeRate extends Model
{
   
       protected $fillable=['id','hsn_code_id','tax_rate_id','created_data','modify_data','status'];
       
       protected $table='hsn_code_tax_rate'; 

       
     public function masterIds()
     {
         return $this->morphMany(MasterCreateUpdate::class, 'masterable');
     }  

    public function assign_hsn_code(){

      return  $this->belongsTo(HSNCode::class,'hsn_code_id');
    }  

      public function assign_tax_rate()
      {
         return  $this->belongsTo(TaxRate::class,'tax_rate_id');
      }  

       


}
