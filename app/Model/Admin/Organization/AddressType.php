<?php

namespace App\Model\Admin\Organization;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\Admin\Master\MasterCreateUpdate;

class AddressType extends Model
{
       use SoftDeletes;
       protected $fillable=['name','status'];
       protected $guarded = [''];
       protected $table="org_address_type";

       public function masterIds()
       {
           return $this->morphMany(MasterCreateUpdate::class, 'masterable');
       }
   


}
