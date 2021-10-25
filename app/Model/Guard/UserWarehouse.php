<?php

namespace App\Model\Guard;

use App\Model\Card;
use app\Model\Warehouse\Invoice;
use App\Warehouse\ManagerPacket;
use App\Model\Guard\UserWarehouse;
use App\Model\Admin\Master\CountryCode;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\Admin\Master\MasterCreateUpdate;
use Illuminate\Foundation\Auth\User as Authenticatable;


class UserWarehouse extends Authenticatable
{
         
    protected $guarded = [''];
        
    protected $table="user_warehouse";

    public function guardName()
    {
          return $this->belongsTo('App\Model\Admin\Setting\Guard','guard_id');
    }

    public function countryCode()
    {
        return $this->belongsTo('App\Model\Admin\Master\CountryCode','country_phone_code_id');
    }

    public function configAssignRole()
    {
          return $this->belongsTo('App\Model\Admin\Setting\DepartmentUserRole','role_id','id');
    }

    public function role()
    {
        return $this->belongsTo("App\Model\Admin\Setting\WarehouseRole",'role_id','id');
    }


    public function vendors()
    {
        return $this->hasMany("App\Model\Warehouse\vendor","warehouse_id",'id');
    } 

    public function managerChallan()
    {
        return $this->hasMany("App\Model\Warehouse\ManagerChallan",'manager_id','id');
    }

    public function managerChallanAssign()
    {
        return $this->hasMany("App\Model\Warehouse\ManagerChallan",'super_id','id');
    }

    public function managerPackets()
    {
        return $this->hasMany(ManagerPacket::class,'manager_id','id');
    }

    public function superPackets()
    {
        return $this->hasMany(ManagerPacket::class,'super_id','id');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class,'user_id_receive','id');
    }

    
    public function getPhoneWithCode($userId)
    {
        $user = UserWarehouse::find($userId);
        $code = CountryCode::find($user->phone_country_code_id); 
        return $code->phonecode.$user->phone;
    }

    public function getWhatsAppWithCode($userId)
    {
        $user = UserWarehouse::find($userId);
        $code = CountryCode::find($user->whats_app_country_code_id); 
        return $code->phonecode.$user->whats_app;
    }

    public function fromCards()
    {
      return $this->morphMany(Card::class,'cardable','from_cardable_type','from_cardable_id','id');
    }

    public function toCards()
    {
      return $this->morphMany(Card::class,'cardable','to_cardable_type','to_cardable_id','id');
    }

    public function masterIds()
    {
      return $this->morphMany(MasterCreateUpdate::class, 'masterable');
    }

}
