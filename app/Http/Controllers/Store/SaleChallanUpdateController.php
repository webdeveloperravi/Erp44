<?php

namespace App\Http\Controllers\Store;

use App\Helpers\Helper;
use App\Model\Store\Ledger;
use App\Helpers\StoreHelper;
use Illuminate\Http\Request;
use App\Model\Guard\UserStore;
use App\Model\Store\LedgerDetail;
use App\Model\Admin\Master\Product;
use App\Http\Controllers\Controller;
use App\Model\Warehouse\InvoiceDetailGradeProduct;
 

class SaleChallanUpdateController extends Controller
{
    public function index($saleChallan)
    { 
         $saleChallan = Ledger::with('ledgerDetails')->where('id',$saleChallan)->first();
        return view('store.SaleChallanUpdate.index',compact('saleChallan'));
    }
    
    public function all($saleChallanId)
    {
        $saleChallan = Ledger::where(['id'=>$saleChallanId,'from'=>auth('store')->user()->id])->first();
        return view('store.SaleChallanUpdate.all',compact('saleChallan'));

    }

     public function addProduct(Request $request)
     {        
         $ledger = Ledger::find($request->ledger_id);
         $result = Helper::getStoreId() == Helper::getUserStoreId($ledger->to) ? true : false;
         $ledgerStock = $this->isProductInStock($request);  

        if($ledgerStock){
            $productStock = InvoiceDetailGradeProduct::where('gin',$request->gin)->first(); 
            $discount =   UserStore::find(Helper::getUserStoreId($ledger->to))->role->retailModel->discount;
            $product = StoreHelper::getProductGradeRattiRattiRateMrpAmount($productStock); 
            $finalAmounts = StoreHelper::getFinalAmounts($ledger->to,$product,$result); 

            LedgerDetail::create([

                'ledger_id' => $ledger->id,
                'product_stock_id' => $productStock->id,
                'gin' => $productStock->gin,
                'weight' => $productStock->weight ?? "0",
                'product_unit_qty' => $product['productStockRatti'],
                'product_unit_rate' => $product['rattiRate'],
                'ledger_status' => 1,

                'product_amount' => $product['mrpAmount'], 

                'discount_id' =>  $result ? 0 : $discount->id,
                'discount_amount' => $finalAmounts['discountAmount'] ,
                'discount_rate' => $result ? 0 : $discount->rate,
                'amount_with_discount' => $finalAmounts['amountWithDiscount'],

                'tax_type_id' =>  $finalAmounts['taxTypeId'],
                'tax_rate' =>  $finalAmounts['taxRate'],
                'tax_amount' =>  $finalAmounts['taxAmount'],
                'ratti_rate_without_tax' =>  $finalAmounts['rattiRateWithoutTax'],
                'mrp_without_tax' =>  $finalAmounts['mrpWithoutTax'],

                'total_amount' => $finalAmounts['finalAmount']
            ]); 

            LedgerDetail::where('id', LedgerDetail::where(['gin'=>$productStock->gin,'new_ledger_id'=>null])
                        ->first()->id)->update(['new_ledger_id' => $ledger->id]);

            $ledgerId = $ledger->id;
            $productsAmount = $ledger->countProductAmount($ledgerId);
        $rattiRateWithoutTax = $ledger->countRattiRateWithoutTax($ledgerId);
        $mrpWithoutTax = $ledger->countMrpWithoutTax($ledgerId);
        $discount = $ledger->countTotalDiscount($ledgerId);
        $amountWithDiscount = $ledger->countAmountWithDiscount($ledgerId);
        $tax = $ledger->countTotalTax($ledgerId);
        $totalAmount = $ledger->countTotalAmount($ledgerId);
        $totalQty = $ledger->countTotalQty($ledgerId);
        
        Ledger::where('id',$ledgerId) ->update([
            'products_amount' => $productsAmount,
            'ratti_rate_without_tax' => $rattiRateWithoutTax,
            'mrp_without_tax' => $mrpWithoutTax,
            'discount_amount' => $discount,
            'amount_with_discount' => $amountWithDiscount,
            'tax_amount' => $tax,
            'total_amount' => $totalAmount,
            'qty_total' => $totalQty,
        ]);           
            return response()->json(['success'=>true]);
        }else{
            return response()->json(['success'=>false , 'msg'=> 'Gin Not Exist']);
        }
     } 
    
 

     public function getLedgerTotalQty($ledgerId){
        return LedgerDetail::where('ledger_id',$ledgerId)->count();
        
     }

     public function getLedgerTotalAmount($ledgerId){
        $countCarat = LedgerDetail::where('ledger_id',$ledgerId)->pluck('product_amount')->toArray();
        $countCarat = collect($countCarat);
        $countCarat = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
         }); 
         return $countCarat;
     }

     public function deleteProduct($ledgerDetailId)
     {   
        if(LedgerDetail::where('ledger_id',LedgerDetail::where('id',$ledgerDetailId)->first()->ledger->id)->count() == 1){
            return response()->json(['success'=>false]);
        }else{
            $ledgerId = LedgerDetail::where('id',$ledgerDetailId)->first()->ledger->id;
         $ledgerDetail =  LedgerDetail::where('id',$ledgerDetailId)->first(); 
         $oldLedgerDetail = LedgerDetail::where('gin',$ledgerDetail->gin)->where('new_ledger_id',$ledgerId)->update(['new_ledger_id'=> null]);
         LedgerDetail::where('id',$ledgerDetailId)->first()->delete();
         Ledger::where('id',$ledgerId)->update([
            'qty_total' => $this->getLedgerTotalQty($ledgerId),
            'total_amount' =>$this->getLedgerTotalAmount($ledgerId),
        ]);

         return response()->json(['success'=>true]);
        }

        if(LedgerDetail::where('ledger_id',LedgerDetail::where('id',$ledgerDetailId)->first()->ledger->id)->count() == 1){
            return response()->json(['success'=>false]);
        }else{
        $ledgerId = LedgerDetail::where('id',$ledgerDetailId)->first()->ledger->id;
        $ledgerDetail =  LedgerDetail::where('id',$ledgerDetailId)->first(); 
        $oldLedgerDetail = LedgerDetail::where('gin',$ledgerDetail->gin)->where('new_ledger_id',$ledgerId)->update(['new_ledger_id'=> null]);

        LedgerDetail::where('id',$ledgerDetailId)->first()->delete();

        $productsAmount = $ledger->countProductAmount($ledgerId);
        $rattiRateWithoutTax = $ledger->countRattiRateWithoutTax($ledgerId);
        $mrpWithoutTax = $ledger->countMrpWithoutTax($ledgerId);
        $discount = $ledger->countTotalDiscount($ledgerId);
        $tax = $ledger->countTotalTax($ledgerId);
        $totalAmount = $ledger->countTotalAmount($ledgerId);
        $totalQty = $ledger->countTotalQty($ledgerId);
        
        Ledger::where('id',$ledgerId) ->update([
            'products_amount' => $productsAmount,
            'ratti_rate_without_tax' => $rattiRateWithoutTax,
            'mrp_without_tax' => $mrpWithoutTax,
            'discount_amount' => $discount,
            'tax_amount' => $tax,
            'total_amount' => $totalAmount,
            'qty_total' => $totalQty,
        ]);
        
        return response()->json(['success'=>true]);
        }
     }

     public function isProductInStock(Request $request){
  
        $authUser = UserStore::find(auth('store')->user()->id);
        if($authUser->type == 'org' || $authUser->type == 'lab')
        {
            if( $ledgerStock = LedgerDetail::with('ledger')->where(['gin' => $request->gin, 'new_ledger_id' => null])
                      ->whereHas('ledger', function ($q) {
                         $q->where(['account_id' =>auth('store')->user()->id, 'voucher_type'=>'1']);
                       })->first() ?? false ){
              return $ledgerStock;
            }
            elseif( $ledgerStock = LedgerDetail::with('ledger')
                                 ->where(['gin' => $request->gin, 'new_ledger_id' => null])
                                 ->whereHas('ledger', function ($q)  {
                                          $q->where(['to' =>auth('store')->user()->id, 'voucher_type'=>'2']);
                                 })->first() ?? false){
                 return $ledgerStock;
            } else
            {
                 return false;
            }
        } else {
            $ledgerStock = LedgerDetail::with('ledger')
                         ->where(['gin' => $request->gin, 'new_ledger_id' => null])
                         ->whereHas('ledger', function ($q)  {
                                 $q->where(['to' =>auth('store')->user()->id, 'voucher_type'=>'2']);
                             })->first() ?? false;
            return $ledgerStock;
        }
 
 
     }
 
          
}

