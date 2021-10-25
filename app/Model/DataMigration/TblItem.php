<?php

namespace App\Model\DataMigration;

use App\Ifvalue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TblItem extends Model
{
    protected $guarded = [''];
    protected $table = 'tbl_item';
    use SoftDeletes;
    public function ifValue()
    {
        return $this->hasOne(Ifvalue::class,'item_id','item_id');
    }

   
    
}
