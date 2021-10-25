<?php

namespace App;

use App\Ifvalue;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'tbl_item';
    protected $guarded = ['']; 

    public function ifValue(){
        return $this->hasOne(Ifvalue::class,'item_id','item_id');
    }
}
