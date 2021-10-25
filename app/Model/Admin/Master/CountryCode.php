<?php

namespace App\Model\Admin\Master;

use Illuminate\Database\Eloquent\Model;

class CountryCode extends Model
{
    protected $table="country_codes";

    public function storeAddress(){
        
        return $this->hasMany("app\Model\Admin\Organization\StoreAddress",'country_id','id');
    }

    public function warehouseUser(){

    return $this->hasOne("App\Model\Guard\UserWarehouse",'whats_app_country_code_id','id');

    }

    
}
