<?php

namespace App\Model\Admin\Master;

use App\Model\Admin\Master\Product;
use Illuminate\Database\Eloquent\Model;
use App\Model\Admin\Organization\TaxRate;
use App\Model\Admin\Master\AssignHsnCodeRate;

class HSNCode extends Model
{
         
        //  protected $fillable=["id","tax_rate_id","hsn_code","description","created_by","status"];
        protected $guarded =[''];
        protected $table="hsn_codes";

         public function masterIds()
         {
             return $this->morphMany(MasterCreateUpdate::class, 'masterable');
         }  

        //  public function assigned_tax_rate(){

        //  	return $this->hasMany(AssignHsnCodeRate::class,'tax_rate_id','id');
        //  }

        public function product(){
            return $this->hasOne(Product::class,'hsn_code','id');
        }

        public function activeTax()
        {
         	return $this->hasMany(AssignHsnCodeRate::class,'hsn_code_id','id')->where('status',1);
        }

        public function taxes()
        {
         	return $this->hasMany(AssignHsnCodeRate::class,'tax_rate_id','id');
        }

        public function hsnCode(){
            return $this->hasOne(AssignHsnCodeRate::class,'hsn_code_id','id')->where('status',1);  
        }

    

        

}
