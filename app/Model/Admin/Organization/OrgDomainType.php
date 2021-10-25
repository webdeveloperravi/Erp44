<?php

namespace App\Model\Admin\Organization;

use Illuminate\Database\Eloquent\Model;

class OrgDomainType extends Model
{
       public $fillable=['id','domain_type','status'];
       public $table="org_domain_type";

       public function domain(){
              return $this->hasOne('App\Model\Admin\Organization\StoreDomain','domain_type_id','id');
       }
}
