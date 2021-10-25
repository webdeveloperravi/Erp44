<?php
namespace App\Services\Cheque;

use App\Model\Store\Ledger;
use App\Model\Store\Cheque;


class ChequeFind{

  public static function chequeFindFromLedger($cheque){
  
        return  Ledger::where(['voucher_type'=>10,'new_ledger_id'=>null,'cheque_id'=>$cheque])->first();
  }
 
  public static function chequeFindFromCheque($cheque)
  {
       return  Cheque::where(['id'=>$cheque,'in_stock'=>0,'cleared'=>0])->first();
  }


}
