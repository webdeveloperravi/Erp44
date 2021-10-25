<?php

namespace App\Http\Controllers\Store;

use Session;
use App\Helpers\Helper;
use App\Model\Store\Ledger;
use Illuminate\Http\Request;
use App\Model\Guard\UserStore;
use App\Model\Store\StoreZone;
use App\Model\Store\DeliveryMode;
use App\Model\Store\LedgerDetail;
use App\Model\Admin\Master\Voucher;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Model\Admin\Organization\ZoneCity;
use App\Model\Warehouse\InvoiceDetailGradeProduct;


class SaleReturnController extends Controller
{
    
    public function index()
    {   
        // $netRattiRate = Helper::getNetRattiRate(2125,0.25);
        // $netDiscountRate  = Helper::getNetDiscount(Helper::getNetRattiRate(2125,0.25),15);
        // $discountAmount  = Helper::getDiscountAmount($netRattiRate,$netDiscountRate);
        // $taxAmount = Helper::getTaxAmount($discountAmount,0.25);
        // $totalAmount = Helper::getTotalAmount($discountAmount,$taxAmount);
        // $crossCheck = Helper::crossCheck(2125,15);
        // dd($crossCheck);

        return view('store.SaleReturn.index');
    }

    public function allReturns()
    {
        $saleReturns = Ledger::with(['userIssue', 'userReceipt'])->
                                 where('voucher_type','4')
                                ->where('from', auth('store')->user()->id)->latest()->get();
         return view('store.SaleReturn.all', compact('saleReturns'));
    }

    public function preparedSaleReturnDetail($id)
    {
        $parentStoreId = auth('store')->user()->parentStore->id ?? null;
         if($parentStoreId == null)
       {
        $saleReturn = Ledger::where(['account_id' => auth('store')->user()->id, 'id' => $id])->first();
       }
       else{
         $saleReturn = Ledger::where(['from' => auth('store')->user()->id, 'id' => $id])->first();
       }
        return view('store.SaleReturn.saleReturnDetail', compact('saleReturn'));
    }
 

    public function create()
    {  
      $myStoreId = \App\Helpers\Helper::getStoreId(); 
      $zoneIds = StoreZone::where('store_id',$myStoreId)->pluck('zone_id')->toArray();
      $zoneCities = ZoneCity::whereIn('zone_id',$zoneIds)->pluck('city_id')->toArray(); 
      $accounts = UserStore::whereHas('addresses',function($q) use ($zoneCities){
        $q->where('address_type_id',1)->whereIn('city_id',$zoneCities);
        })->where('type','org')->orWhere('type','lab')
      ->get() 
        ;        
        return view('store.SaleReturn.create', compact('accounts'));
    }

    public function getManagers($accountId)
    {
        $managers = UserStore::select('id','name')
        ->where([
            // 'org_id' => $accountId, 
            // 'type' => 'user'
            ])
        ->orWhere('id',$accountId)->get(); 
        return view('store.SaleReturn.managerList', compact('managers','accountId'));
    }

    public function returnChallanToReturn(Request $request)
    {
        $this->validate($request, [
            'gins'=> 'required'
        ]);
    
        $gins = collect($request->gins);
        foreach($gins as $gin){
            $this->returnChallanToReturnSave($gin);
            if($gins->last() == $gin){
                Session::flash('create',true);
                return redirect()->route('saleOrderReturn.index');
            }
        }

    }

    public function returnChallanToReturnSave($productId)
    {      
         dd($request->all());

   
            $ledgerStock = LedgerDetail::where('product_stock_id',$productId)
                          ->whereHas('Ledger',function($q){
                               $q->where('voucher_type','8');
                          })->firstOrFail();

            if ($ledgerStock)
            {
                $return = Session::get('return');
                if (!$return)
                {
                $return = [$ledgerStock->id => [
                         'gin' => $ledgerStock->gin, 
                         'productStockId' => $ledgerStock->product_stock_id, 
                         'product'  => $ledgerStock->productStock->product->name, 
                         'grade' => $ledgerStock->productStock->productGrade->grade, 
                         'ratti' => $ledgerStock->productStock->ratti->rati_standard, 
                         'exactRatti' => $ledgerStock->product_unit_qty, 
                         'exactRattiRate' => $ledgerStock->product_unit_rate, 
                         'productAmount' => $ledgerStock->product_amount
                         ]];
                    Session::put('return', $return);
                    return response()->json(['success' => true, 'msg' => "Product Inserted Success"]);
                }
                elseif (isset($return[$ledgerStock->id]))
                {
                    return response()->json(['exist' => true, 'msg' => 'Product Already Added']);
                }
                $return[$ledgerStock->id] = ['gin' => $ledgerStock->gin, 'productStockId' => $ledgerStock->product_stock_id, 'product' => $ledgerStock
                    ->productStock
                    ->product->name, 'grade' => $ledgerStock
                    ->productStock
                    ->productGrade->grade, 'ratti' => $ledgerStock
                    ->productStock
                    ->ratti->rati_standard, 'exactRatti' => $ledgerStock->product_unit_qty, 'exactRattiRate' => $ledgerStock->product_unit_rate, 'productAmount' => $ledgerStock->product_amount];
                Session::put('return', $return);

                return true;
            } 
         

    }

    public function saveReturnDetails(Request $request)
    {
   
             $validator = Validator::make($request->all() , 
                [
                    'gin' => 'required', 
                    'account' => 'required|not_in:0', 
                    'manager' => 'required|not_in:0',
                 ]); 
        if ($validator->passes())
        {
            $ledgerStock = $this->isProductInStock($request);
            if ($ledgerStock)
            {
                $return = Session::get('return');
                if (!$return)
                {
                $return = [$ledgerStock->id => [
                         'gin' => $ledgerStock->gin, 
                         'productStockId' => $ledgerStock->product_stock_id, 
                         'product'  => $ledgerStock->productStock->product->name, 
                         'grade' => $ledgerStock->productStock->productGrade->grade, 
                         'ratti' => $ledgerStock->productStock->ratti->rati_standard, 
                         'exactRatti' => $ledgerStock->product_unit_qty, 
                         'exactRattiRate' => $ledgerStock->product_unit_rate, 
                         'productAmount' => $ledgerStock->product_amount
                         ]];
                    Session::put('return', $return);
                    return response()->json(['success' => true, 'msg' => "Product Inserted Success"]);
                }
                elseif (isset($return[$ledgerStock->id]))
                {
                    return response()->json(['exist' => true, 'msg' => 'Product Already Added']);
                }
                $return[$ledgerStock->id] = ['gin' => $ledgerStock->gin, 'productStockId' => $ledgerStock->product_stock_id, 'product' => $ledgerStock
                    ->productStock
                    ->product->name, 'grade' => $ledgerStock
                    ->productStock
                    ->productGrade->grade, 'ratti' => $ledgerStock
                    ->productStock
                    ->ratti->rati_standard, 'exactRatti' => $ledgerStock->product_unit_qty, 'exactRattiRate' => $ledgerStock->product_unit_rate, 'productAmount' => $ledgerStock->product_amount];
                Session::put('return', $return);

                return response()->json(['success' => true, 'msg' => "Product Inserted Success"]);
            }else
            {
              return response()->json(['success' => false, 'msg' => "GIN Does Not Exists"]);
            }
        }else
        {
            $keys = $validator->errors()
                ->keys();
            $vals = $validator->errors()
                ->all();
            $errors = array_combine($keys, $vals);
            return response()->json(['errors' => $errors]);
        }

    }

    public function isProductInStock(Request $request){
  
       $authUser = UserStore::find(auth('store')->user()->id);

       if($authUser->type = 'org' || $authUser->type == 'lab')
       {

           if( $ledgerStock = LedgerDetail::with('ledger')->where(['gin' => $request->gin, 'new_ledger_id' => null])
                     ->whereHas('ledger', function ($q) {
                        $q->where(['account_id' =>auth('store')->user()->id, 'voucher_type'=>'1']);
                      })->first() ?? false ){
         
             return $ledgerStock;

           } 
           elseif( $ledgerStock = LedgerDetail::with('ledger')->where(['gin' => $request->gin, 'new_ledger_id' => null])->whereHas('ledger', function ($q)  {
                   $q->where(['to' =>auth('store')->user()->id, 'voucher_type'=>'3']);
                    })->first() ?? false){
                return $ledgerStock;
           }
           else
           {
                
                return false;

           }

       }
       else
       {
           $ledgerStock = LedgerDetail::with('ledger')->where(['gin' => $request->gin, 'new_ledger_id' => null])->whereHas('ledger', function ($q)  {
                   $q->where(['to' =>auth('store')->user()->id, 'voucher_type'=>'4']);
                    })->first() ?? false;
           return $ledgerStock;
       }


    }

    // remove Product From Session
    public function removeProduct($id)
    {
        $return = Session::get('return');
        if (isset($return[$id]))
        {
            unset($return[$id]);
            Session::put('return', $return);
        }
        return response()->json(['success' => true]);
    }

    public function saleReturnDetails()
    {

        $collection = Session::get('return');
        $returnData = Session::get('return');

        $arrayData = collect($returnData)->pluck('productAmount')
            ->all();

        $total_amount = $this->getTotalAmount($arrayData);
        return view('store.SaleReturn.allProducts', compact('collection', 'total_amount'));
    }
 

  

    public function saveReturn(Request $request)
    {
          $validator = Validator::make($request->all() , [
                'credit_to' => 'required|not_in:0',
                 ]);

        $returnData = Session::get('return');
       
        if(count($returnData) > 0){
            $arrayData = collect($returnData)->pluck('productAmount')->all();
       
            if ($validator->passes())
            {
                $voucherTypeId ='4';
                $debitorVoucherNumber = $this->getSaleReturnVoucherNumber();
                $ledger = Ledger::create([
                    'guard_id_from' => auth('store')->user()->guard_id,
                    'guard_id_to' => auth('store')->user()->guard_id,
                    'voucher_type' => $voucherTypeId,
                    'voucher_number' => $debitorVoucherNumber,
                    'account_id' =>  $this->getAccountIdForSaleReturn(),
                    'from' =>auth('store')->user()->id,
                    'to' =>$request->credit_to,
                    'qty_total' => count(Session::get('return')) ,
                    'amount_total' => $this->getTotalAmount($arrayData) ,
                    'comment' => $request->comment, 'status' => '1',
    
                     ]);
            }
            else
            {
                $keys = $validator->errors()
                    ->keys();
                $vals = $validator->errors()
                    ->all();
                $errors = array_combine($keys, $vals);
                return response()->json(['errors' => $errors]);
            }
    
             foreach (Session::get('return') as $id => $product)
                {   
    
                    $discount =   UserStore::find(Helper::getUserStoreId($request->credit_to))
                                            ->role->retailModel->discount;
                    $discountId = $discount->id;
                    $discountRate = $discount->rate;  
                    $taxTypeId = InvoiceDetailGradeProduct::find($product['productStockId'])
                    ->product->hsnCode->activeTax[0]->assign_tax_rate->AssignTaxType->id;
                    $taxRate = InvoiceDetailGradeProduct::find($product['productStockId'])
                                ->product->hsnCode->activeTax[0]->assign_tax_rate->rate;
                    $netRattiRate = Helper::getNetRattiRate($product['exactRattiRate'],$taxRate) * $product['exactRatti']  ; 
                    $netDiscountRate  = Helper::getNetDiscount($netRattiRate,$discountRate);
                    $discountAmount  = Helper::getDiscountAmount($netRattiRate,$netDiscountRate) ;
                    $taxAmount = Helper::getTaxAmount($discountAmount,$taxRate);
                    $totalAmount = Helper::getTotalAmount($discountAmount,$taxAmount);
     
                    LedgerDetail::create([
                        'ledger_id' => $ledger->id, 
                        'product_stock_id' => $product['productStockId'], 
                        'gin' => $product['gin'], 
                        'product_unit_qty' => $product['exactRatti'],
                        'product_unit_rate' => $product['exactRattiRate'], 
                        'product_amount' =>  round($totalAmount,2), 
                        'ledger_status' => 1,
                        'discount_id' =>  $discountId,
                        'discount_rate' =>  $discountRate,
                        'tax_type_id' =>  $taxTypeId,
                        'tax_rate' =>  $taxRate,
                        'discount_amount' => round($discountAmount,2) ,
                        'tax_amount' =>  round($taxAmount,2), 
                        'total_amount' =>  $product['productAmount'] 
                    ]);
    
                    LedgerDetail::where(['id' => $id])->update(['new_ledger_id' => $ledger->id]);
    
                }
    
                Session::forget('return');
                return response()
                    ->json(['success' => true, 'msg' => "Return Successfully Created.{{$debitorVoucherNumber}}", 'returnNumber' => $debitorVoucherNumber]);
        }else{
            return true;
        }   
    }

   public function getSaleReturnVoucherNumber(){
   $authUser = UserStore::find(auth('store')->user()->id);

    if($authUser->type == 'org' || $authUser->type == 'lab'){
 
  
       if($ledger = Ledger::where(['account_id' =>$authUser->id,'voucher_type' =>'4'])->latest()->first() ?? false)
       {
          return $ledger->voucher_number+1;

       }else{
          return 1001;
       }
    }else{

        if($ledger = Ledger::where(['account_id' =>$authUser->parentStore->id,'voucher_type' =>'4'])->latest()->first() ?? false)
        {
             return $ledger->voucher_number+1;
        }else{
            return 1001;
        }
    }
   }

  

   public function getAccountIdForSaleReturn(){

    $authUser = UserStore::where('id',auth('store')->user()->id)->first();

    //dd($authUser->type);
    if($authUser->type =='user')
    {
   
      return $authUser->parentStore->id;
    }
      if($authUser->type == 'org' || $authUser->type == 'lab')
      {
            return $authUser->id;
      }
   }


    // Not Use Save Return Method
    public function createIssueReturn(Request $request)
    { 
        $debitor = UserStore::where('id', auth('store')->user()
            ->id)
            ->first();
        $ledger = Ledger::create(['guard_id_from' => auth('store')->user()->guard_id, 'guard_id_to' => auth('store')
            ->user()->guard_id, 'from_voucher_type_id' => $voucherTypeId, 'to_voucher_type_id' => $voucherTypeId, 'from_voucher_number' => $debitorVoucherNumber, 'to_voucher_number' => $creditVoucherNumber, 'account_id_from' => auth('store')->user()->id, 'account_id_to' => $request->manager, 'qty_total' => LedgerDetail::where('temp_number', Session::get('temp_return_number'))
            ->count() , 'status' => '1', ]);

        foreach ($ledgerDetails as $detail)
        {
            $detail->update(['ledger_id' => $ledger->id]);
        }

        $updateDebitorVoucherNumber = UserStore::where('id', auth('store')->user()
            ->id)
            ->first()
            ->update(['voucher_number' => $debitorVoucherNumber]);

        $updateCreditorVoucherNumber = UserStore::where('id', $request->credit_to)
            ->first()
            ->update(['voucher_number' => $creditorVoucherNumber]);

        $debitor->update(['SaleReturn_temp_number' => null]);
        Session::forget('temp_return_number');
        return view('store.prepare_order.success');
    }

    public function getTotalAmount($amount)
    {
        $collection = collect($amount);
        $total_amount = $collection->reduce(function ($carry, $item)
        {
            return $carry + $item;
        });
        return $total_amount;

    }

    public  function issueReturnAll(){
 
        $userId = $this->getAccountIdForSaleReturn();
        $managers = UserStore::where(['org_id'=>$userId,'type'=>'user'])->pluck('id')->toArray();
        $allStoreIds =array_merge($managers,[$userId]);
        $saleReturns  = Ledger::with(['userIssue', 'userReceipt'])->whereIn('from',$allStoreIds)->where('voucher_type','4')->orderBy('id','desc')->get();
        return view('store.SaleReturn.issueReturnAll.all',compact('saleReturns'));
       
       
     }
     
     public function issueReturnDetail($id)
     {
           $issueReturnDetail = Ledger::with('ledgerDetails')->where('id', $id)->first();
             return view('store.SaleReturn.issueReturnAll.issueReturnDetail', compact('issueReturnDetail'));
     }
     
     
        public function receiveReturnAll(){
         
        $userId = $this->getAccountIdForSaleReturn();
       
         $managers = UserStore::where(['org_id'=>$userId,'type'=>'user'])->pluck('id')->toArray();
         $allStoreIds =array_merge($managers,[$userId]);
         $receiveReturns  = Ledger::with(['userIssue', 'userReceipt'])->whereIn('to',$allStoreIds)->where(['voucher_type'=>'4','account_id'=>$userId])->orderBy('id','desc')->get();
        return view('store.SaleReturn.receiveReturnAll.all',compact('receiveReturns'));   
         
        
        }


      






}
