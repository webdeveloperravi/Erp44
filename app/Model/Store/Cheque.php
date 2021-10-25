<?php

namespace App\Model\Store;

use App\Model\Store\Ledger;
use App\Model\Guard\UserStore;
use Illuminate\Database\Eloquent\Model;

class Cheque extends Model
{
    protected $guarded = [''];


    public function ledger(){
      
        return $this->belongsTo(Ledger::class,'ledger_id','id');
    }

    public function ledgers()
    {
        return $this->hasMany(Ledger::class,'cheque_id','id');
    }

    public function store()
    {
        return $this->hasOne(UserStore::class,'store_id','id');
    }
}
