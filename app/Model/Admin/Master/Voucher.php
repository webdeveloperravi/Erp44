<?php

namespace App\Model\Admin\Master;

use App\Model\Store\Ledger;
use App\Model\Store\LedgerDetailTemp;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    
    protected $guarded = [''];
    protected  $table  = 'vouchers';
    
    public function masterIds()
    {
        return $this->morphMany(MasterCreateUpdate::class, 'masterable');
    }
  

  public function ledgerDetailTemps()
  {
      return $this->hasMany(LedgerDetailTemp::class,'voucher_type_id','id');
  }

  public function ledger(){
      return $this->hasMany(Ledger::class,'voucher_type','id');
  }
    
}
