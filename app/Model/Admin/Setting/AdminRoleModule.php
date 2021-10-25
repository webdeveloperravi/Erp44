<?php

namespace App\Model\Admin\Setting;

use Illuminate\Database\Eloquent\Model; 
use App\Model\Admin\Setting\AdminAction;
use App\Model\Admin\Setting\AdminRoleAction;

class AdminRoleModule extends Model
{   
	protected $guarded = [''];
    protected $table ="admin_role_module";
 
}
