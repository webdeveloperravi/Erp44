<?php

namespace App\Model\Admin\Organization;

use App\Model\Guard\UserStore;
use Illuminate\Database\Eloquent\Model;
use App\Model\Admin\Organization\TaxType;
use Illuminate\Database\Eloquent\SoftDeletes;
use  App\Model\Admin\Organization\AddressType;

class StoreAddress extends Model
{
    use SoftDeletes;
    
    protected $guarded = [''];
    
    protected $table = 'store_address';

    public function store()
    {
    	return $this->belongsTo(UserStore::class,'store_id','id');
    }

    public function country(){
        return $this->belongsTo('App\Model\Admin\Master\Country','country_id','id');
    }

    public function state(){
        return $this->belongsTo('App\Model\Admin\Master\CountryState','state_id','id');
    }

    public function town(){
        return $this->belongsTo('App\Model\Admin\Master\CountryStateCity','town_id','id');
    }

    public function city(){
        return $this->belongsTo('App\Model\Admin\Master\CountryStateCity','city_id','id');
    }

    public function account(){
        return $this->belongsTo(UserStore::class,'store_id','id');
    }

    public function addressType(){
       
         return $this->belongsTo(AddressType::class,'address_type_id','id');
    }

    public function taxType()
    {
        return $this->belongsTo(TaxType::class,'tax_type_id','id');
    }

     


}
