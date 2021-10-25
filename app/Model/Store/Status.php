<?php

namespace App\Model\Store;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $guarded = ['']; 
    public function statusable(){

      return $this->morphTo();
        
    }
}
