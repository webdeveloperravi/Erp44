<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LoginHistory extends Model
{
    protected $table = 'login_histories';
    protected $guarded =[''];
    
    public function loginHistoryAble(){
        return $this->morphTo('login_histories','login_historyable_id','login_historyable_type');
    }
}
