<?php

namespace App\Model\Warehouse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends Model
{
    
    use SoftDeletes;

    public $fillable = ['id','warehouse_id','company_name','name','email','phone','country_id','state_id','city_id','locality','landmark','address','pincode','gst_number','status','created_at','updated_at'];
    
    protected $table="vendors";


    public function country(){

          return $this->belongsTo('App\Model\Admin\Master\Country','country_id','id');
    }

    public function state(){

          return $this->belongsTo('App\Model\Admin\Master\CountryState','state_id','id');
    }

    public function city(){

          return $this->belongsTo('App\Model\Admin\Master\CountryStateCity','city_id','id');
    } 

    public function warehouse(){

    	return $this->belongsTo('App\Model\Guard\UserWarehouse','warehouse_id','id');
    }

    public function invoice(){

        return $this->hasMany('App\Model\Warehouse\Invoice','vendor_id','id');
    }



}
