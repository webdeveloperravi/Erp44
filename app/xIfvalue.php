<?php

namespace App;

use App\Item;
use Illuminate\Database\Eloquent\Model;

class Ifvalue extends Model
{
    protected $table = 'tbl_ifvalue';
    protected $guarded = [''];

    public function item(){
        return $this->belongsTo(Item::class,'item_id','item_id');
    }

}
