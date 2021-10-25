<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Model\Guard\UserStore;
use App\Model\Store\LedgerDetail;
use App\Model\Admin\Master\Product;
use App\Http\Controllers\Controller;
use App\Model\Admin\Master\ProductMGrade;
use App\Model\Admin\Master\ProductMWeightRange;
use App\Model\Warehouse\InvoiceDetailGradeProduct;

class StoreProductStockCheckController extends Controller
{
    public function index(){
         
        $products = Product::all();
        $grades = ProductMGrade::all();
        $rattis = ProductMWeightRange::all();

        return view('store.storeProductStockCheck.index',compact('products','grades','rattis'));
    }

  

    public function getAllProducts($product,$grade,$ratti){

        $products = InvoiceDetailGradeProduct::where([
            'product_id' => $product, 
            'grade_id' => $grade,
            'ratti_id' => $ratti
            ])->get();

        return view('store.storeProductStockCheck.all',compact('products'));
    }

  

    public function getProducts(Request $request)
    {    
        $authUser = UserStore::find(auth('store')->user()->id);

        if($authUser->type = 'org' || $authUser->type == 'lab')
        {
            
            $productStockIds1 = $ledgerStock = LedgerDetail::with('ledger')->where(['new_ledger_id' => null])
                                        ->whereHas('ledger', function ($q) {
                                        $q->where(['account_id' =>auth('store')->user()->id, 'voucher_type'=>'1']);
                                        })->pluck('product_stock_id')->toArray();

            $productStockIds2 = $ledgerStock = LedgerDetail::with('ledger')->where(['new_ledger_id' => null])
            
                                               ->whereHas('ledger', function ($q)  {
                                                   $q->where(['to' =>auth('store')->user()->id, 'voucher_type'=>'2']);
                                                })->pluck('product_stock_id')->toArray();

            $productStockIds3 = $ledgerStock = LedgerDetail::with('ledger')->where(['new_ledger_id' => null])
            
                                               ->whereHas('ledger', function ($q)  {
                                                   $q->where(['to' =>auth('store')->user()->id, 'voucher_type'=>'3']);
                                                })->pluck('product_stock_id')->toArray();

            $productStockIds = array_merge($productStockIds1,$productStockIds2,$productStockIds3);

        }elseif($authUser->type = 'user') {
            $productStockIds = LedgerDetail::with('ledger')->where(['new_ledger_id' => null])
                                ->whereHas('ledger', function ($q)  {
                                        $q->where(['to' =>auth('store')->user()->id, 'voucher_type'=>'2']);
                                })->get();
        }



        



        $products = InvoiceDetailGradeProduct::select('id','gin','product_id','grade_id','ratti_id')
                                                ->with('product','productGrade','ratti') 
                                                ->when($request->product_id != 0 , function($query) use ($request) {
                                                        $query->where('product_id',$request->product_id);
                                                })
                                                ->when($request->grade_id != 0 , function($query) use ($request) {
                                                        $query->where('grade_id',$request->grade_id);
                                                })
                                                ->when($request->ratti_id != 0 , function($query) use ($request) {
                                                        $query->where('ratti_id',$request->ratti_id);
                                                })
                                                ->whereIn('id',$productStockIds)
                                                ->get();
        return view('store.storeProductStockCheck.all',compact('products'));
    }
 
}
