<?php

namespace App\Model\Store;

use App\Model\Store\Cheque;
use App\Model\Store\Ledger;
use App\Model\Store\Status;
use App\Helpers\StoreHelper;
use App\Model\Guard\UserStore;
use App\Model\Store\StoreZone;
use App\Model\Store\LedgerDetail;
use App\Model\Admin\Setting\Guard;
use App\Model\Admin\Master\Voucher;
use App\Model\Store\StorePurchaseOrder;
use Illuminate\Database\Eloquent\Model;
use App\Model\Admin\Organization\ZoneCity;
use App\Model\Admin\Organization\DiscountRate;
use App\Model\Store\PaymentDaybook\PaymentDaybook;
use App\Model\Store\PaymentDaybook\PaymentDaybookAll;

class Ledger extends Model
{
    protected $guarded = [''];

    public function ledgerDetails(){
        return $this->hasMany(LedgerDetail::class,'ledger_id','id');
    }

    public function userIssue(){
        return $this->belongsTo(UserStore::class,'from','id'); 
    }

    public function userReceipt(){
        return $this->belongsTo(UserStore::class,'to','id');
    } 

    public function storeReceipt(){
        return $this->belongsTo(UserStore::class,'account_id','id');
    } 
 

    public function userReceiptOpeningStock(){
        return $this->belongsTo(UserStore::class,'account_id','id');
    } 

    public function voucher(){
        return $this->belongsTo(Voucher::class,'voucher_type','id');
    }

    public function discount(){
        $this->belongsTo(DiscountRate::class,'discount_rate_id','id');
    }
 
    //Payment Ledger Functions
    public function getDebitAmount($accountId,$ledgerId){
        
        $ledger = Ledger::find($ledgerId);
        if($ledger->from == $accountId){
            return $ledger->qty_total;
        }else{
            return false;
        }
    }
    
    public function getCreditAmount($accountId,$ledgerId){
        
        $ledger = Ledger::find($ledgerId);
        if($ledger->to == $accountId){
            return $ledger->qty_total;
        }else{
            return false;
        }
    }

    public function getValues($accountId,$ledgerId){
        
        $totalDebit = $this->countDebit($accountId,$ledgerId);
        $totalCredit = $this->countCredit($accountId,$ledgerId);

        if($totalDebit > $totalCredit){
            return $totalDebit - $totalCredit." Dr.";
        }else{
            return $totalCredit - $totalDebit." Cr.";
        }
    }

    public function countDebit($accountId,$ledgerId){
        
        $ledger = Ledger::find($ledgerId);
        // $stockLedgers = Ledger::where('credit_to',$accountId)->get()->pluck('id');
        $stockLedgers = Ledger::where(['to'=>$accountId])->get()->pluck('id');
        $countCarat = Ledger::whereIn("id",$stockLedgers)->where('created_at','<=',$ledger->created_at)->pluck("qty_total")->all();
        $countCarat = collect($countCarat);
        $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
         }); 
         return $countCarat;
    }

    public function countCredit($accountId,$ledgerId){
        
        $ledger = Ledger::find($ledgerId);
        // $stockLedgers = Ledger::where('debit_by',$accountId)->get()->pluck('id');
        $stockLedgers = Ledger::where(['from'=>$accountId])->get()->pluck('id');
        
        $countCarat = Ledger::whereIn("id",$stockLedgers)->where('created_at','<=',$ledger->created_at)->pluck("qty_total")->all();
        $countCarat = collect($countCarat);
        $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
         }); 
         return $countCarat;
    }
    

    public function getTotalDebit($accountId){
        
        $countCarat = Ledger::where(['from'=>$accountId])->get()->pluck('qty_total');
        $countCarat = collect($countCarat);
        $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
         }); 
         return $countCarat;
    }

    public function getTotalCredit($accountId){
        
        $countCarat = Ledger::where(['to'=>$accountId])->get()->pluck('qty_total');
        $countCarat = collect($countCarat);
        $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
         }); 
         return $countCarat;
    }
 
    //Trial Stock Report Approval
    public function getTotalDebitAmountApproval($store1Accounts,$store2Accounts)
    { 

        $countCarat = Ledger::whereIn('from',$store1Accounts)
                                    ->whereIn('to',$store2Accounts)
                                    ->whereIn('voucher_type',[2])
                                    ->get()->pluck('total_amount');
        $countCarat = collect($countCarat);
        $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
         }); 
         return $countCarat;
    }

    public function getTotalCreditAmountApproval($store1Accounts,$store2Accounts){ 

        $countCarat = Ledger::whereIn('to',$store1Accounts)
        ->whereIn('from',$store2Accounts)
        ->whereIn('voucher_type',[2])
        ->get()->pluck('total_amount');
        $countCarat = collect($countCarat);
        $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
         }); 
         return $countCarat;
    }

    public function getTotalDebitCreditAmountApproval($accountId,$authUserId){

        $store1Accounts = UserStore::where(['org_id'=>$accountId,'type'=>'user'])->pluck('id')->toArray();
        $store1Accounts = array_merge($store1Accounts,[$accountId]);  
        $store2Accounts = UserStore::where(['org_id'=>$authUserId,'type'=>'user'])->pluck('id')->toArray();
        $store2Accounts = array_merge($store2Accounts,[$authUserId]); 

        $debit = $this->getTotalDebitAmountApproval($store1Accounts,$store2Accounts);
        $credit = $this->getTotalCreditAmountApproval($store1Accounts,$store2Accounts);
        if($debit > $credit){
            $bal = $debit - $credit." Cr.";
        }else{
         $bal = $credit - $debit." Dr.";
        }
        return [
            'debit' => $debit,
            'credit' => $credit,
            'bal' => $bal
        ];
    }
 
    //Trial Stock Report Final
    public function getTotalDebitAmountFinal($store1Accounts,$store2Accounts)
    { 

        $countCarat = Ledger::whereIn('from',$store1Accounts)
                                    ->whereIn('to',$store2Accounts)
                                    ->whereIn('voucher_type',[3,4,5,6,7])
                                    ->get()->pluck('total_amount');
        $countCarat = collect($countCarat);
        $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
         }); 
         return $countCarat;
    }

    public function getTotalCreditAmountFinal($store1Accounts,$store2Accounts){ 

        $countCarat = Ledger::whereIn('to',$store1Accounts)
        ->whereIn('from',$store2Accounts)
        ->whereIn('voucher_type',[3,4,5,6,7])
        ->get()->pluck('total_amount');
        $countCarat = collect($countCarat);
        $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
         }); 
         return $countCarat;
    }

    public function getTotalDebitCreditAmountFinal($accountId,$authUserId){

        $store1Accounts = UserStore::where(['org_id'=>$accountId])->pluck('id')->toArray();
        $store1Accounts = array_merge($store1Accounts,[$accountId]);  
        $store2Accounts = UserStore::where(['org_id'=>$authUserId])->pluck('id')->toArray();
        $store2Accounts = array_merge($store2Accounts,[$authUserId]); 

        $debit = $this->getTotalDebitAmountFinal($store1Accounts,$store2Accounts);
        $credit = $this->getTotalCreditAmountFinal($store1Accounts,$store2Accounts);
        if($debit > $credit){
            $bal = $debit - $credit." Cr.";
        }else{
         $bal = $credit - $debit." Dr.";
        }
        return [
            'debit' => $debit,
            'credit' => $credit,
            'bal' => $bal
        ];
    }
 
    //Trial Stock Report By Voucher
    public function getTotalDebitAmountByVoucher($store1Accounts,$store2Accounts,$voucherType)
    { 
        $countCarat = Ledger::whereIn('from',$store1Accounts)
                                    ->whereIn('to',$store2Accounts)
                                    ->where('voucher_type',$voucherType)
                                    ->get()->pluck('total_amount');
        $countCarat = collect($countCarat);
        $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
        }); 
        return $countCarat; 
 
    }

    public function getTotalCreditAmountByVoucher($store1Accounts,$store2Accounts,$voucherType){ 
        
        
        $countCarat = Ledger::whereIn('to',$store1Accounts)
        ->whereIn('from',$store2Accounts)
        ->where('voucher_type',$voucherType)
        ->get()->pluck('total_amount');
        $countCarat = collect($countCarat);
        $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
         }); 
         return $countCarat; 
    }

    public function getTotalDebitCreditAmountByVoucher($accountId,$authUserId,$voucherType){

        $store1Accounts = UserStore::where(['org_id'=>$accountId])->pluck('id')->toArray();
        $store1Accounts = array_merge($store1Accounts,[$accountId]);  
        $store2Accounts = UserStore::where(['org_id'=>$authUserId])->pluck('id')->toArray();
        $store2Accounts = array_merge($store2Accounts,[$authUserId]); 

        $debit = $this->getTotalDebitAmountByVoucher($store1Accounts,$store2Accounts,$voucherType);
        $credit = $this->getTotalCreditAmountByVoucher($store1Accounts,$store2Accounts,$voucherType);
         
        if($debit > $credit){
            $bal = $debit - $credit." Cr.";
        }else{
         $bal = $credit - $debit." Dr.";
        }
        return [
            'debit' => $debit,
            'credit' => $credit,
            'bal' => $bal
        ];  
    }


    





    public function getTotalBalance($accountId){
        
       $totalDebit = $this->getTotalDebit($accountId);
       $totalCredit = $this->getTotalCredit($accountId);
       if($totalDebit > $totalCredit){
           return $totalDebit - $totalCredit." Cr.";
       }else{
        return $totalCredit - $totalDebit." Dr.";
       }
    }

    public function minus($debit,$credit)
    {
        if($debit > $credit){
            return $debit - $credit." Cr.";
        }else{
         return $credit - $debit." Dr.";
        }
    }

 

    public function statuses()
    {
        return $this->morphMany(Status::class, 'statusable','statusable_type','statusable_id');
    }

    public function authGuard()
    {
        return $this->belongsTo(Guard::class,'guard_id','id');
    }
    
    //Used In Opening Stock
    public function getLeftQty($ledgerId)
    { 
         
         return LedgerDetail::where('ledger_id',$ledgerId)->where('new_ledger_id',null)->count(); 
    }
    
    //Used In Opening Stock
    public function getLeftAmount($ledgerId)
    {  
        $countCarat = LedgerDetail::where('ledger_id',$ledgerId)->where('new_ledger_id',null)->get()->pluck('total_amount');
        $countCarat = collect($countCarat);
        $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
         }); 
         return $countCarat;
    }

    public function getSaleChallanTotalAmount($ledgerId)
    {
        $countCarat = LedgerDetail::where('ledger_id',$ledgerId)->get()->pluck('product_amount');
        $countCarat = collect($countCarat);
        $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
         }); 
         return $countCarat;
    }

    public function getReceiveChallanTotalAmount($ledgerId)
    {
        $countCarat = LedgerDetail::where('ledger_id',$ledgerId)->get()->pluck('product_amount');
        $countCarat = collect($countCarat);
        $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
         }); 
         return $countCarat;
    }


    //Invoice Functions
    public function countTotalQty($ledgerId)
    { 
         
        return  LedgerDetail::where('ledger_id',$ledgerId)->count(); 
    }

    public function countTotalDiscount($ledgerId)
    { 
         
        $countCarat = LedgerDetail::where('ledger_id',$ledgerId)->pluck("discount_amount")->all();
        $countCarat = collect($countCarat);
        $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
            }); 
            return $countCarat; 
    }

    public function countAmountWithDiscount($ledgerId)
    { 
         
        $countCarat = LedgerDetail::where('ledger_id',$ledgerId)->pluck("amount_with_discount")->all();
        $countCarat = collect($countCarat);
        $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
            }); 
            return $countCarat; 
    }

    public function countTotalTax($ledgerId)
    { 
         
        $countCarat = LedgerDetail::where('ledger_id',$ledgerId)->pluck("tax_amount")->all();
        $countCarat = collect($countCarat);
        $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
            }); 
            return $countCarat; 
    }

    public function countProductAmount($ledgerId)
    { 
         
        $countCarat = LedgerDetail::where('ledger_id',$ledgerId)->pluck("product_amount")->all();
        $countCarat = collect($countCarat);
        $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
            }); 
            return $countCarat; 
    }
    
    public function countTotalAmount($ledgerId)
    { 
         
        $countCarat = LedgerDetail::where('ledger_id',$ledgerId)->pluck("total_amount")->all();
        $countCarat = collect($countCarat);
        $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
            }); 
            return $countCarat; 
    }
    
    public function countRattiRateWithoutTax($ledgerId)
    { 
         
        $countCarat = LedgerDetail::where('ledger_id',$ledgerId)->pluck("ratti_rate_without_tax")->all();
        $countCarat = collect($countCarat);
        $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
            }); 
            return $countCarat; 
    }
    
    public function countMrpWithoutTax($ledgerId)
    { 
         
        $countCarat = LedgerDetail::where('ledger_id',$ledgerId)->pluck("mrp_without_tax")->all();
        $countCarat = collect($countCarat);
        $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
            }); 
            return $countCarat; 
    }

    
   ///////////////////////////////////////////////////
    public function mediaImages(){
        return $this->morphMany('App\Model\Image','imageable');
    }

    public function discountRate($storeId){
        $authUser = UserStore::find(StoreHelper::getUserStoreId($storeId));
        if($authUser->type == 'org' || $authUser->type == 'lab')
        {    
            return $authUser->role->retailModel->discount->rate ?? 0;  
        }else{
           return 0;
        }
    }

    public function discountAmountForStore($storeId,$amount){
        $authUser = UserStore::find($storeId);
        // dd($authUser);
        if($authUser->type == 'org' || $authUser->type == 'lab')
        {     
            $discount =  $authUser->role->retailModel->discount->rate; 
            return  $amount * ($discount/100);
        }else{
           return 0;
        }
    }

    public function getAmountAfterDiscount($discountAmount,$totalAmount){
        return $totalAmount - $discountAmount;
    }

    public  function convertNumberToWord($num = false)
    {
    $num = str_replace(array(',', ' '), '' , trim($num));
    if(! $num) {
        return false;
    }
    $num = (int) $num;
    $words = array();
    $list1 = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven',
        'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
    );
    $list2 = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety', 'hundred');
    $list3 = array('', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
        'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
        'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
    );
    $num_length = strlen($num);
    $levels = (int) (($num_length + 2) / 3);
    $max_length = $levels * 3;
    $num = substr('00' . $num, -$max_length);
    $num_levels = str_split($num, 3);
    for ($i = 0; $i < count($num_levels); $i++) {
        $levels--;
        $hundreds = (int) ($num_levels[$i] / 100);
        $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ' ' : '');
        $tens = (int) ($num_levels[$i] % 100);
        $singles = '';
        if ( $tens < 20 ) {
            $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '' );
        } else {
            $tens = (int)($tens / 10);
            $tens = ' ' . $list2[$tens] . ' ';
            $singles = (int) ($num_levels[$i] % 10);
            $singles = ' ' . $list1[$singles] . ' ';
        }
        $words[] = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_levels[$i] ) ) ? ' ' . $list3[$levels] . ' ' : '' );
    } //end for loop
    $commas = count($words);
    if ($commas > 1) {
        $commas = $commas - 1;
    }
    return implode(' ', $words);
}

public function cheque()
{
    return $this->belongsTo(Cheque::class,'cheque_id','id');
}

public function isPreparedOrder()
{
    return \App\Model\Store\StorePurchaseOrder::where('ledger_id',$this->id)->exists();
}

public function order()
{
    return $this->belongsTo(StorePurchaseOrder::class,'id','ledger_id');
} 

public function createdBy()
{
    return $this->belongsTo(UserStore::class,'created_by','id');
}

     
}
