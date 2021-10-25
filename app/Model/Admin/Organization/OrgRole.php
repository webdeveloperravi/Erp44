<?php

namespace App\Model\Admin\Organization;
use App\Model\Admin\Setting\Module;
use Illuminate\Database\Eloquent\Model;
use App\Model\Admin\Organization\RetailModel;
use App\Model\Admin\Master\MasterCreateUpdate;

class OrgRole extends Model
{
   
// protected $fillable=["id","name","status","created_by"];
protected $guarded =[""];
protected $table="org_roles";

public function masterIds()
{
      return $this->morphMany(MasterCreateUpdate::class, 'masterable');
}


public function retailModel()
{
   return $this->belongsTo(RetailModel::class,'retail_model_id','id');
}

public function taxType()
{

   return $this->belongsTo(TaxType::class,'tax_type_id','id');
}

public function unit()
{
   return $this->belongsTo(Unit::class,'unit_id','id');
}

public function modules(){
   return $this->belongsToMany(Module::class,'org_role_module','role_id','module_id')->withPivot('c','r','u','d')->orderBy('parent_sort');;
}

 

public function store()
{
   return $this->hasMany(UserStore::class,'role_id','id');
}
}
