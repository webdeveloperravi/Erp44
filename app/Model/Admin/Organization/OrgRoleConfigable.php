<?php

namespace App\Model\Admin\Organization;

use Illuminate\Database\Eloquent\Model;

class OrgRoleConfigable extends Model
{
    
  protected $fillable=["org_id","org_role_id","org_role_configable_id","org_configable_type","status","created_by"];
   protected $table="org_role_configables";


 }
