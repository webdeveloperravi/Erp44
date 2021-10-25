<?php

namespace App\Model\Store;

use App\Model\Store\Lead;
use App\Model\Store\LeadType;
use App\Model\Guard\UserStore;
use App\Model\Store\LeadSource;
use App\Model\Store\LeadStatus;
use App\Model\Store\LeadContact;
use App\Model\Admin\Master\Country;
use App\Model\Store\AccountComment;
use App\Model\Admin\Master\CountryCode;
use Illuminate\Database\Eloquent\Model;
use App\Model\Admin\Master\CountryState;
use App\Model\Admin\Master\CountryStateCity;
use App\Model\Admin\Organization\AddressType;
 

class Lead extends Model
{
    protected $guarded = [''];
    protected $table ="leads";

    public function leadStatus(){
        return $this->belongsTo(LeadStatus::class,'lead_status_id','id');
    }

    public function leadType(){
        return $this->belongsTo(LeadType::class,'lead_type_id','id');
    }
    
    public function manager(){
        return $this->belongsTo(UserStore::class,'store_user_id','id');
    }
    
    public function creator(){
        return $this->belongsTo(UserStore::class,'created_by','id');
    }

    public function store(){
        return $this->belongsTo(UserStore::class,'store_id','id');
    }

    public function leadSource(){
        return $this->belongsTo(LeadSource::class,'lead_source_id','id');
    }

    public function country(){
        return $this->belongsTo(Country::class,'country_id','id');
    }

    public function state(){
        return $this->belongsTo(CountryState::class,'state_id','id');
    }
    
    public function city(){
        return $this->belongsTo(CountryStateCity::class,'city_id','id');
    }
    
    public function  town(){
        return $this->belongsTo(CountryStateCity::class,'town_id','id');
    }

    public function comments(){
        return $this->morphMany('App\Model\Comment','commentable');
    }

    public function images(){
        return $this->morphMany('App\Model\Image','imageable');
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords($value);
    }
    
    public function getPhoneWithCode($leadId){

        $lead = Lead::find($leadId);
        $code = CountryCode::find($lead->phone_country_code_id); 
        return $code->phonecode.$lead->phone;
    }
    
    public function getWhatsAppWithCode($leadId){

        $lead = Lead::find($leadId);
        $code = CountryCode::find($lead->whats_app_country_code_id);
        return $code->phonecode.$lead->whats_app ?? 'No';
    }
    public function leadContacts(){

        return $this->hasMany(LeadContact::class,'lead_id','id');
    }

     public function addressType(){
        return $this->belongsTo(AddressType::class,'address_type_id','id');
    }

    //   public function leadComments()
    // {
    //     return $this->morphMany(AccountComment::class, 'commentable','commentable_type','commentable_id');
    // }

    public function socialMedias()
    {
        return $this->hasMany(SocialMedia::class,'lead_id','id');
    }
    
}
