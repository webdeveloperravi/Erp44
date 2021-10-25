<?php

namespace App\Model\Admin\Master;

use Illuminate\Database\Eloquent\Model;
use App\Model\Admin\Master\MasterCreateUpdate;

class Fluorescence extends Model
{
    protected $guarded = [''];
    public $table ='fluorescences';

    
    public function masterIds()
    {
        return $this->morphMany(MasterCreateUpdate::class, 'masterable');
    }  


}
