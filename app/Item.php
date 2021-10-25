<?php

namespace App;

use App\Ifvalue;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{   
    // protected $connection = 'mysql2';
    protected $table = 'tbl_item';
    protected $guarded = ['']; 
    public $timestamps =false;

    public function ifValue(){
        return $this->hasOne(Ifvalue::class,'item_id','item_id');
    }
}
