<?php

namespace App\Http\Controllers\Store;

use App\Helpers\Helper;
use App\Model\Store\Ledger;
use App\Helpers\StoreHelper;
use Illuminate\Http\Request;
use App\Model\Guard\UserStore;
use App\Model\Store\LedgerDetail;
use App\Http\Controllers\Controller;
use App\Model\Warehouse\InvoiceDetailGradeProduct;
 

class ReceiveChallanUpdateController extends Controller
{
     public function index($receiveChallanId)
     { 
        $receiveChallan = Ledger::with('ledgerDetails')->where(['id'=>$receiveChallanId,'to'=>auth('store')->user()->id])->first();
        if($receiveChallan){
            return view('store.ReceiveChallanUpdate.index',compact('receiveChallan'));
        }else{
            abort(404);
        }
        
    }
    
    public function all($receiveChallanId)
    {
        $receiveChallan = Ledger::where(['id'=>$receiveChallanId,'to'=>auth('store')->user()->id])->first();
        return view('store.ReceiveChallanUpdate.all',compact('receiveChallan'));

     }

     public function addProduct(Request $request)
     {    
        //  $ledgerStock = $this->isProductInStock($request); 
        //  if($ledgerStock){
        //     LedgerDetail::create([
        //         'ledger_id' => $request->ledger_id, 
        //         'gin' => $ledgerStock->gin, 
        //         'product_stock_id' => $ledgerStock->product_stock_id, 
        //         'product'  => $ledgerStock->productStock->product->name, 
        //         'grade' => $ledgerStock->productStock->productGrade->grade, 
        //         'ratti' => $ledgerStock->productStock->ratti->rati_standard, 
        //         'product_unit_qty' => $ledgerStock->product_unit_qty, 
        //         'product_unit_rate' => $ledgerStock->product_unit_rate, 
        //         'product_amount' => $ledgerStock->product_amount
        //     ]);
        //     $updated =  LedgerDetail::where('id',$ledgerStock->id)->update(['new_ledger_id'=>$request->ledger_id]);
        //     return response()->json(['success'=>true]);
        //  }else{
        //      return response()->json(['success'=>false , 'msg'=> 'Gin Not Exist']);
        //  }

         $ledger = Ledger::find($request->ledger_id);
        //  $result = Helper::getStoreId() == Helper::getUserStoreId($ledger->to) ? true : false;
         $ledgerDetail = $this->isProductInStock($request,$ledger->from);  

        if($ledgerDetail){
            // $productStock = InvoiceDetailGradeProduct::where('gin',$request->gin)->first(); 
            // $discount =   UserStore::find(Helper::getUserStoreId($ledger->to))->role->retailModel->discount;
            // $product = StoreHelper::getProductGradeRattiRattiRateMrpAmount($productStock); 
            // $finalAmounts = StoreHelper::getFinalAmounts($ledger->to,$product,$result); 

            // $ledgerDetail = LedgerDetail::where('id',$product['ledgerDetailId'])->first();
            
            LedgerDetail::create([
                'ledger_id' => $ledger->id,
                'product_stock_id' => $ledgerDetail->product_stock_id,
                'gin' => $ledgerDetail->gin,
                'weight' => $ledgerDetail->weight ?? 0,
                'product_unit_qty' => $ledgerDetail->product_unit_qty,
                'product_unit_rate' => $ledgerDetail->product_unit_rate,
                'ledger_status' => $ledgerDetail->ledger_status,

                'product_amount' => $ledgerDetail->product_amount,

                'discount_id' =>  $ledgerDetail->discount_id,
                'discount_amount' => $ledgerDetail->discount_amount,
                'discount_rate' =>  $ledgerDetail->discount_rate,

                'tax_type_id' =>  $ledgerDetail->tax_type_id,
                'tax_rate' =>  $ledgerDetail->tax_rate,
                'tax_amount' =>  $ledgerDetail->tax_amount,
                'ratti_rate_without_tax' => $ledgerDetail->ratti_rate_without_tax,
                'mrp_without_tax' =>  $ledgerDetail->mrp_without_tax,

                'total_amount' => $ledgerDetail->total_amount,
            ]); 
            LedgerDetail::where('id', LedgerDetail::where(['id'=>$ledgerDetail->id,'new_ledger_id'=>null])->first()->id)->update(['new_ledger_id' => $ledger->id]);

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

     public function deleteProduct($ledgerDetailId)
     {    

        if(LedgerDetail::where('ledger_id',LedgerDetail::where('id',$ledgerDetailId)->first()->ledger->id)->count() == 1){
            return response()->json(['success'=>false]);
        }else{
        $ledgerId = LedgerDetail::where('id',$ledgerDetailId)->first()->ledger->id;
         
        $ledgerDetail =  LedgerDetail::where('id',$ledgerDetailId)->first(); 
        $oldLedgerDetail = LedgerDetail::where('gin',$ledgerDetail->gin)->where('new_ledger_id',$ledgerId)->update(['new_ledger_id'=> null]);

        LedgerDetail::where('id',$ledgerDetailId)->first()->delete();
        $ledger = Ledger::find($ledgerId);
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

     public function isProductInStock(Request $request,$accountId){
         
        $authUser = UserStore::find(auth('store')->user()->id);
        if($authUser->type == 'org' || $authUser->type == 'lab')
        {
            if( $ledgerStock = LedgerDetail::with('ledger')->where(['gin' => $request->gin, 'new_ledger_id' => null])
                      ->whereHas('ledger', function ($q) use ($accountId){
                         $q->where(['account_id' =>$accountId, 'voucher_type'=>'1']);
                       })->first() ?? false ){
              return $ledgerStock;
            }
            elseif( $ledgerStock = LedgerDetail::with('ledger')
                                 ->where(['gin' => $request->gin, 'new_ledger_id' => null])
                                 ->whereHas('ledger', function ($q) use($accountId) {
                                          $q->where(['to' =>$accountId, 'voucher_type'=>'2']);
                                 })->first() ?? false){
                 return $ledgerStock;
            } else
            {
                 return false;
            }
        } else {
            $ledgerStock = LedgerDetail::with('ledger')
                         ->where(['gin' => $request->gin, 'new_ledger_id' => null])
                         ->whereHas('ledger', function ($q) use ($accountId)  {
                                 $q->where(['to' =>$accountId, 'voucher_type'=>'2']);
                             })->first() ?? false;
            return $ledgerStock;
        }
 
 
     }
 
          
}

