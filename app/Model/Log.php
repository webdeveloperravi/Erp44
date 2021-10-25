<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $guarded =[];
    public function logable(){
        return $this->morphTo();
    }
}
