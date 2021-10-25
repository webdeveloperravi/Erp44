<?php
namespace App\Model\Guard;

use App\Model\LoginHistory;
use App\Model\Guard\UserAdmin;
use App\Model\Admin\Master\CountryCode;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\Admin\Master\MasterCreateUpdate;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserAdmin extends Authenticatable
{
    use SoftDeletes;

    public const GuardId = 2;

    // protected $fillable = ['last_seen', 'id', 'guard_id', 'role_id', 'org_id', 'country_phone_code_id', 'name', 'email_primary', 'email_secondary', 'whatsapp', 'mobile_secondary', 'password', 'otp_code', 'user_pic', 'security_pin', 'email_verify', 'phone_verify', 'status', 'created_by', 'ip_address', 'browser', 'operatiing_system', 'device', 'session_status', 'logged'];
    protected $guarded =[''];

    protected $table = "user_admin";

    public function guardName()
    {
        return $this->belongsTo('App\Model\Admin\Setting\Guard', 'guard_id');
    }

    public function countryCode()
    {
        return $this->belongsTo('App\Model\Admin\Master\CountryCode', 'country_phone_code_id');
    }

    public function configAssignRole()
    {
        return $this->belongsTo('App\Model\Admin\Setting\DepartmentUserRole', 'role_id', 'id');
    }

    public function role()
    {
        return $this->belongsTo("App\Model\Admin\Setting\AdminRole", 'role_id', 'id');
    }

    public function loginHistories(){
      return $this->morphMany(LoginHistory::class,'loginHistoryAble','login_historyable_id','login_historyable_type');
    }

    
    public function getPhoneWithCode($userId){

        $user = UserAdmin::find($userId);
        $code = CountryCode::find($user->phone_country_code_id); 
        return $code->phonecode.$user->phone;
    }
    public function getWhatsAppWithCode($userId){

        $user = UserAdmin::find($userId);
        $code = CountryCode::find($user->whats_app_country_code_id); 
        return $code->phonecode.$user->whats_app;
    }
    
  public function masterIds()
  {
      return $this->morphMany(MasterCreateUpdate::class, 'masterable');
  }  
}

