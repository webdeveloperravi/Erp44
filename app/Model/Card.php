<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{ 
    protected $guarded =[''];
    public function cardable()
    {
         return $this->morphTo();
    }
}
