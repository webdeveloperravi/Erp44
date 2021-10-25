<?php

namespace App\Model\Admin\Setting;

use App\Model\Store\Ledger;
use Illuminate\Database\Eloquent\Model;

class Guard extends Model
{
       protected $fillable=['id','name','alias','parent','parent_sort','status'];
       protected $table="guard";



       public function guardName()
       {
       	 return $this->hasOne('App\Model\Admin\Setting\Guard','guard_id');
       }

       public function subGuardName()
       {
          return $this->hasMany('App\Model\Admin\Setting\Guard','parent','id');
       }

       public function ledgers()
       {
          return $this->hasMany(Ledger::class,'guard_id','id');
       }


}
