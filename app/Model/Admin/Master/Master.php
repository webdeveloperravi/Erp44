<?php

namespace App\Model\Admin\Master;

use Illuminate\Database\Eloquent\Model;

class Master extends Model
{
    protected $fillable = ['name', 'status', 'created_by'];
    protected $table="masters";
  
    public function masterIds()
    {
        return $this->morphMany(MasterCreateUpdate::class, 'masterable');
    }


}
