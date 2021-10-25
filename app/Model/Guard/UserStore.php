<?php

namespace App\Model\Guard;

use App\Model\Log;
use App\Model\Domain;
use App\Model\Comment;
use App\Model\Store\Bank;
use App\Model\Store\Cash;
use App\Model\Store\Lead;
use App\Model\Store\Ledger;
use App\Model\Guard\UserStore;
use App\Model\Store\ManagerRole;
use App\Model\Store\AccountImage;
use App\Model\Admin\Setting\Module;
use App\Model\Store\AccountComment;
use App\Model\Admin\Organization\Zone;
use App\Model\Store\LedgerDetailTemp;
use App\Model\Admin\Master\CountryCode;
use App\Model\Admin\WhiteListIpAddress;
use App\Model\Store\StorePurchaseOrder;
use Illuminate\Database\Eloquent\Model;
use App\Model\Admin\Master\AccountGroup;
use App\Model\Admin\Organization\OrgRole;
use App\Model\SecurityPinRegenerateRequest;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\Admin\Organization\StoreAddress;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserStore extends Authenticatable
{
    use SoftDeletes;

    protected $guarded = [''];

    protected $table = "user_store";

    public function guardName()
    {
        return $this->belongsTo('App\Model\Admin\Setting\Guard', 'guard_id');
    }

    public function ledgers()
    {
        return $this->hasMany(Ledger::class, 'account_id_from', 'id');
    }

    public function issuedLedgers()
    {
        return $this->hasMany(Ledger::class, 'from', 'id');
    }

    public function receiptLedgers()
    {
        return $this->hasMany(Ledger::class, 'to', 'id');
    }

    public function role()
    {
        return $this->belongsTo(OrgRole::class, 'store_role_id', 'id');
    }

    public function managerRole()
    {
        return $this->belongsTo(ManagerRole::class, 'manager_role_id', 'id');
    }

    public function storeLeads()
    {
        return hasMany(Lead::class, 'store_id', 'id');
    }

    public function managerLeads()
    {
        return hasMany(Lead::class, 'store_user_id', 'id');
    }

    // public function comments(){
    //     return $this->hasMany(Comment::class,'store_user_id','id');
    // }

    public function parentStore()
    {
        return $this->belongsTo(UserStore::class, 'org_id', 'id');
    }

    public function childStores()
    {
        return $this->hasMany(UserStore::class, 'org_id', 'id');
    }

    public function purchaseOrders()
    {
        return $this->hasMany(StorePurchaseOrder::class, 'buyer_store_id', 'id');
    }

    public function store()
    {
        return $this->belongsTo(UserStore::class, 'org_id', 'id');
    }

    public function managers()
    {
        return $this->hasMany(UserStore::class, 'org_id', 'id');
    }

    public function accountGroup()
    {
        return $this->belongsTo(AccountGroup::class, 'account_group_id', 'id');
    }

    public function addresses()
    {
        return $this->hasmany(StoreAddress::class, 'store_id', 'id')->orderBy('id', 'desc');
    }

    public function headOfficeAddress()
    {
        return $this->hasOne(StoreAddress::class, 'store_id', 'id')->where('address_type_id', 1);
    }

    public function primaryAddress()
    {
        return $this->hasOne(StoreAddress::class, 'store_id', 'id')->where('address_type_id', 1);
    }

    public function getPhoneWithCode($userId)
    {

        $user = UserStore::find($userId) ?? false;
        $code = CountryCode::find($user->phone_country_code_id) ?? false;
        if ($user && $code) {
            return $code->phonecode . $user->phone;
        } else {
            return '';
        }
    }

    public function getWhatsAppWithCode($userId)
    {


        $user = UserStore::find($userId) ?? false;
        $code = CountryCode::find($user->whats_app_country_code_id);
        if ($user && $code) {
            return $code->phonecode . $user->whats_app;
        } else {
            return '';
        }
    }

    // public function accountComments()
    // {
    //     return $this->morphMany(AccountComment::class, 'commentable','commentable_type','commentable_id');
    // }

    public function comments()
    {
        return $this->morphMany('App\Model\Comment', 'commentable');
    }


    // public function images()
    // {
    //     return $this->morphMany(AccountImage::class, 'imageable','imageable_type','imageable_id');
    // }

    public function images()
    {
        return $this->morphMany('App\Model\Image', 'imageable');
    }

    public function banks()
    {

        return $this->hasMany(Bank::class, 'org_id', 'id')->where('account_group_id', 12);;
    }


    public function zones()
    {

        return $this->belongsToMany(Zone::class, 'store_zones', 'store_id', 'zone_id');
    }

    public function managerZones()
    {
        return $this->belongsToMany(Zone::class, 'manager_zones', 'manager_id', 'zone_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(UserStore::class, 'created_by', 'id');
    }

    public function createdAccounts()
    {
        return $this->hasMany(UserStore::class, 'created_by', 'id');
    }

    public function managerRoles()
    {
        return $this->hasMany(ManagerRole::class, 'store_id', 'id');
    }

    public function storeLedgerDetailTemps()
    {
        return $this->hasMany(LedgerDetailTemp::class, 'store_id', 'id');
    }

    public function userLedgerDetailTemps()
    {
        return $this->hasMany(LedgerDetailTemp::class, 'user_id', 'id');
    }

    public function hasManyOrders()
    {
        return $this->hasMany(StorePurchaseOrder::class, 'created_by', 'id');
    }

    public function domains()
    {
        return $this->morphMany(Domain::class, 'domainable')->where('domain_type_id', '1');
    }

    public function subDomain()
    {
        return $this->morphOne(Domain::class, 'domainable')->where('domain_type_id', '2');
    }

    public function logs()
    {
        return $this->morphMany(Log::class, 'logable');
    }

    public function securityPinRegenerateRequests()
    {
        return $this->morphMany(SecurityPinRegenerateRequest::class, 'securityPinRegenerateRequestable', 'requestable_type', 'requestable_id');
    }

    public function whitelistIpAddresses()
    {
        return $this->hasMany(WhiteListIpAddress::class, 'store_id', 'id');
    }

    public function managerIps()
    {
        return $this->belongsToMany(WhiteListIpAddress::class, 'user_store_ip_addresses', 'user_store_id', 'ip_address_id');
    }
}
