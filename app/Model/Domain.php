<?php

namespace App\Model;

use App\Model\Admin\Master\DomainType;
use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    protected $guarded = [];
    
    public function domainable(){

        return $this->morphTo();
    }

    public function domainType(){

        return $this->belongsTo(DomainType::class,'domain_type_id','id');
    }
}
