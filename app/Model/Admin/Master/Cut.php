<?php

namespace App\Model\Admin\Master;
use Illuminate\Database\Eloquent\Model;
use App\Model\Admin\Master\MasterCreateUpdate;

class Cut extends Model
{
    protected $table ='cuts';
    protected $fillable =['id','name','alias','description','created_by' ,'status'];

    public function masterIds()
    {
        return $this->morphMany(MasterCreateUpdate::class, 'masterable');
    }


}
