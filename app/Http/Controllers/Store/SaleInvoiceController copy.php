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


class SaleInvoiceController extends Controller
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

        return view('store.SaleInvoice.index');
    }

    public function allInvoices()
    {
        $saleInvoices = Ledger::with(['userIssue', 'userReceipt'])->
                                 where('voucher_type','3')
                                ->where('from', auth('store')->user()->id)->latest()->get();
         return view('store.SaleInvoice.all', compact('saleInvoices'));
    }

    public function preparedSaleInvoiceDetail($id)
    {
        $parentStoreId = auth('store')->user()->parentStore->id ?? null;
         if($parentStoreId == null)
       {
        $saleInvoice = Ledger::where(['account_id' => auth('store')->user()->id, 'id' => $id])->first();
       }
       else{
         $saleInvoice = Ledger::where(['from' => auth('store')->user()->id, 'id' => $id])->first();
       }
        return view('store.SaleInvoice.saleInvoiceDetail', compact('saleInvoice'));
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
        return view('store.SaleInvoice.create', compact('accounts'));
    }

    public function getManagers($accountId)
    {
        $managers = UserStore::select('id','name')
        ->where([
            // 'org_id' => $accountId, 
            // 'type' => 'user'
            ])
        ->orWhere('id',$accountId)->get(); 
        return view('store.SaleInvoice.managerList', compact('managers','accountId'));
    }

    // public function returnChallanToInvoice(Request $request)
    // {
    //     $this->validate($request, [
    //         'gins'=> 'required'
    //     ]);
    
    //     $gins = collect($request->gins);
    //     foreach($gins as $gin){
    //         $this->returnChallanToInvoiceSave($gin);
    //         if($gins->last() == $gin){
    //             Session::flash('create',true);
    //             return redirect()->route('saleOrderInvoice.index');
    //         }
    //     }

    // }

    // public function returnChallanToInvoiceSave($productId)
    // {      
    //      dd($request->all());

   
    //         $ledgerStock = LedgerDetail::where('product_stock_id',$productId)
    //                       ->whereHas('Ledger',function($q){
    //                            $q->where('voucher_type','8');
    //                       })->firstOrFail();

    //         if ($ledgerStock)
    //         {
    //             $invoice = Session::get('invoice');
    //             if (!$invoice)
    //             {
    //             $invoice = [$ledgerStock->id => [
    //                      'gin' => $ledgerStock->gin, 
    //                      'productStockId' => $ledgerStock->product_stock_id, 
    //                      'product'  => $ledgerStock->productStock->product->name, 
    //                      'grade' => $ledgerStock->productStock->productGrade->grade, 
    //                      'ratti' => $ledgerStock->productStock->ratti->rati_standard, 
    //                      'exactRatti' => $ledgerStock->product_unit_qty, 
    //                      'exactRattiRate' => $ledgerStock->product_unit_rate, 
    //                      'productAmount' => $ledgerStock->product_amount
    //                      ]];
    //                 Session::put('invoice', $invoice);
    //                 return response()->json(['success' => true, 'msg' => "Product Inserted Success"]);
    //             }
    //             elseif (isset($invoice[$ledgerStock->id]))
    //             {
    //                 return response()->json(['exist' => true, 'msg' => 'Product Already Added']);
    //             }
    //             $invoice[$ledgerStock->id] = ['gin' => $ledgerStock->gin, 'productStockId' => $ledgerStock->product_stock_id, 'product' => $ledgerStock
    //                 ->productStock
    //                 ->product->name, 'grade' => $ledgerStock
    //                 ->productStock
    //                 ->productGrade->grade, 'ratti' => $ledgerStock
    //                 ->productStock
    //                 ->ratti->rati_standard, 'exactRatti' => $ledgerStock->product_unit_qty, 'exactRattiRate' => $ledgerStock->product_unit_rate, 'productAmount' => $ledgerStock->product_amount];
    //             Session::put('invoice', $invoice);

    //             return true;
    //         } 
         

    // }

    public function saveInvoiceDetails(Request $request)
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
                $invoice = Session::get('invoice');
                if (!$invoice)
                {
                $invoice = [$ledgerStock->id => [
                         'gin' => $ledgerStock->gin, 
                         'productStockId' => $ledgerStock->product_stock_id, 
                         'product'  => $ledgerStock->productStock->product->name, 
                         'grade' => $ledgerStock->productStock->productGrade->grade, 
                         'ratti' => $ledgerStock->productStock->ratti->rati_standard, 
                         'exactRatti' => $ledgerStock->product_unit_qty, 
                         'exactRattiRate' => $ledgerStock->product_unit_rate, 
                         'productAmount' => $ledgerStock->product_amount
                         ]];
                    Session::put('invoice', $invoice);
                    return response()->json(['success' => true, 'msg' => "Product Inserted Success"]);
                }
                elseif (isset($invoice[$ledgerStock->id]))
                {
                    return response()->json(['exist' => true, 'msg' => 'Product Already Added']);
                }
                $invoice[$ledgerStock->id] = ['gin' => $ledgerStock->gin, 'productStockId' => $ledgerStock->product_stock_id, 'product' => $ledgerStock
                    ->productStock
                    ->product->name, 'grade' => $ledgerStock
                    ->productStock
                    ->productGrade->grade, 'ratti' => $ledgerStock
                    ->productStock
                    ->ratti->rati_standard, 'exactRatti' => $ledgerStock->product_unit_qty, 'exactRattiRate' => $ledgerStock->product_unit_rate, 'productAmount' => $ledgerStock->product_amount];
                Session::put('invoice', $invoice);

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
                   $q->where(['to' =>auth('store')->user()->id, 'voucher_type'=>'3']);
                    })->first() ?? false;
           return $ledgerStock;
       }


    }

    // remove Product From Session
    public function removeProduct($id)
    {
        $invoice = Session::get('invoice');
        if (isset($invoice[$id]))
        {
            unset($invoice[$id]);
            Session::put('invoice', $invoice);
        }
        return response()->json(['success' => true]);
    }

    public function saleInvoiceDetails()
    {

        $collection = Session::get('invoice');
        $invoiceData = Session::get('invoice');

        $arrayData = collect($invoiceData)->pluck('productAmount')
            ->all();

        $total_amount = $this->getTotalAmount($arrayData);
        return view('store.SaleInvoice.allProducts', compact('collection', 'total_amount'));
    }
 

  

    public function saveInvoice(Request $request)
    {
          $validator = Validator::make($request->all() , [
                'credit_to' => 'required|not_in:0',
                 ]);

        $invoiceData = Session::get('invoice');
        $arrayData = collect($invoiceData)->pluck('productAmount')->all();
        
        if ($validator->passes())
        {
            $voucherTypeId ='3';
            $debitorVoucherNumber = $this->getSaleInvoiceVoucherNumber();
            
            $ledger = Ledger::create([
                'guard_id_from' => auth('store')->user()->guard_id,
                'guard_id_to' => auth('store')->user()->guard_id,
                'voucher_type' => $voucherTypeId,
                'voucher_number' => $debitorVoucherNumber,
                'account_id' =>  $this->getAccountIdForSaleInvoice(),
                'from' =>auth('store')->user()->id,
                'to' =>$request->credit_to,
                'qty_total' => count(Session::get('invoice')) ,
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

         foreach (Session::get('invoice') as $id => $product)
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

            Session::forget('invoice');
            return response()
                ->json(['success' => true, 'msg' => "Invoice Successfully Created.{{$debitorVoucherNumber}}", 'invoiceNumber' => $debitorVoucherNumber]);

    }

   public function getSaleInvoiceVoucherNumber(){
   $authUser = UserStore::find(auth('store')->user()->id);

    if($authUser->type == 'org' || $authUser->type == 'lab'){
 
  
       if($ledger = Ledger::where(['account_id' =>$authUser->id,'voucher_type' =>'3'])->latest()->first() ?? false)
       {
          return $ledger->voucher_number+1;

       }else{
          return 1001;
       }
    }else{

        if($ledger = Ledger::where(['account_id' =>$authUser->parentStore->id,'voucher_type' =>'3'])->latest()->first() ?? false)
        {
             return $ledger->voucher_number+1;
        }else{
            return 1001;
        }
    }
   }

  

   public function getAccountIdForSaleInvoice(){

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


    

    public function getTotalAmount($amount)
    {
        $collection = collect($amount);
        $total_amount = $collection->reduce(function ($carry, $item)
        {
            return $carry + $item;
        });
        return $total_amount;

    }

    public  function issueInvoiceAll(){
 
        $userId = $this->getAccountIdForSaleInvoice();
        $managers = UserStore::where(['org_id'=>$userId,'type'=>'user'])->pluck('id')->toArray();
        $allStoreIds =array_merge($managers,[$userId]);
        $saleInvoices  = Ledger::with(['userIssue', 'userReceipt'])->whereIn('from',$allStoreIds)->where('voucher_type','3')->orderBy('id','desc')->get();
        return view('store.SaleInvoice.issueInvoiceAll.all',compact('saleInvoices'));
       
       
     }
     
     public function issueInvoiceDetail($id)
     {
           $issueInvoiceDetail = Ledger::with('ledgerDetails')->where('id', $id)->first();
             return view('store.SaleInvoice.issueInvoiceAll.issueInvoiceDetail', compact('issueInvoiceDetail'));
     }
     
     
        public function receiveInvoiceAll(){
         
        $userId = $this->getAccountIdForSaleInvoice();
       
         $managers = UserStore::where(['org_id'=>$userId,'type'=>'user'])->pluck('id')->toArray();
         $allStoreIds =array_merge($managers,[$userId]);
         $receiveInvoices  = Ledger::with(['userIssue', 'userReceipt'])->whereIn('to',$allStoreIds)->where(['voucher_type'=>'3','account_id'=>$userId])->orderBy('id','desc')->get();
        return view('store.SaleInvoice.receiveInvoiceAll.all',compact('receiveInvoices'));   
         
        
        }


      






}
