<?php

namespace App\Model\Admin\Organization;

use Illuminate\Database\Eloquent\Model;

class SecurityPin extends Model
{
     protected $fillable =['id','store_id','pin'];
     protected $table ='security_pins';

      public function store()
     {
        return $this->belongsTo("App\Model\Admin\Organization\Store",'store_id','id');
     }


}
