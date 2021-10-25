<?php

namespace App\Model\Admin\Master;

use Illuminate\Database\Eloquent\Model;

class DomainType extends Model
{
    public function domains(){
        return $this->hasMany(Doamin::class,'domain_type_id');
    }
}
