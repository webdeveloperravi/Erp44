<?php

namespace App\Model\DataMigration;

use App\Model\DataMigration\TblItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TblIfvalue extends Model
{
    protected $guarded = [''];
    protected $table = 'tbl_ifvalue';
    use SoftDeletes;
    public function item()
    {
        return $this->belongsTo(TblItem::class,'item_id','item_id');
    }
    
}
