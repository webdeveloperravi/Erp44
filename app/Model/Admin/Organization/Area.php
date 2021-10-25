<?php

namespace App\Model\Admin\Organization;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
       protected $fillable=['zone_id','city_id','description','created_by'];
       protected $table="areas";

       public function zone(){

         return $this->belongsTo('App\Model\Admin\Organization\Zone','zone_id','id');
       }

        public function cities(){
        
        return  $this->belongsTo('App\Model\Admin\Master\CountryStateCity','city_id','id'); 
        
       }


}
