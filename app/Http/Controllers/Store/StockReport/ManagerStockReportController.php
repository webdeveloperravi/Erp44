<?php

namespace App\Http\Controllers\Store\StockReport;
 
use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Model\Guard\UserStore;
use App\Model\Store\LedgerDetail; 
use App\Model\Admin\Master\Product;
use App\Model\Admin\Master\Voucher;
use App\Http\Controllers\Controller; 
use App\Model\Admin\Master\ProductMGrade;
use App\Model\Admin\Master\ProductMWeightRange;
use App\Model\Warehouse\InvoiceDetailGradeProduct;
use App\Model\Store\StockLedger\ManagerStockLedger;

class ManagerStockReportController extends Controller
{
    public function index(Request $request){
        
        $managers = Helper::getManagersByTree();
        return view('store.StockReport.ManagerStockReport.index',compact('managers')); 
    } 

    public function all($managerId)
    {  
        $authUser = UserStore::find($managerId);
      
        if($authUser->type == 'org' || $authUser->type == 'lab')
        {   
            
            // $productStockIds1 = $ledgerStock = LedgerDetail::with('ledger')->where(['new_ledger_id' => null])
            //                             ->whereHas('ledger', function ($q) use ($authUser){
            //                             $q->where(['account_id' =>$authUser->id, 'voucher_type'=>'1']);
            //                             })->pluck('product_stock_id')->toArray();

            // $productStockIds2 = $ledgerStock = LedgerDetail::with('ledger')->where(['new_ledger_id' => null])
            
            //                                    ->whereHas('ledger', function ($q)use ($authUser)  {
            //                                        $q->where(['to' =>$authUser->id, 'voucher_type'=>'2']);
            //                                     })->pluck('product_stock_id')->toArray();

            // $productStockIds3 = $ledgerStock = LedgerDetail::with('ledger')->where(['new_ledger_id' => null])
            
            //                                    ->whereHas('ledger', function ($q) use ($authUser) {
            //                                        $q->where(['to' => $authUser->id, 'voucher_type'=>'3']);
            //                                     })->pluck('product_stock_id')->toArray();

            // $productStockIds = array_merge($productStockIds1,$productStockIds2,$productStockIds3);
            $productStockIds1 = $ledgerStock = LedgerDetail::with('ledger')->where(['new_ledger_id' => null])
                                        ->whereHas('ledger', function ($q) {
                                        $q->where(['account_id' =>auth('store')->user()->id, 'voucher_type'=>'1']);
                                        })->pluck('product_stock_id')->toArray();  

            $productStockIds2 = $ledgerStock = LedgerDetail::with('ledger')->where(['new_ledger_id' => null])
            
                                               ->whereHas('ledger', function ($q)  {
                                                   $q->where(['to' =>auth('store')->user()->id])->whereIn('voucher_type',[2,3,4]);
                                                })->pluck('product_stock_id')->toArray();

            // $productStockIds3 = $ledgerStock = LedgerDetail::with('ledger')->where(['new_ledger_id' => null])
            
            //                                    ->whereHas('ledger', function ($q)  {
            //                                        $q->where(['to' =>auth('store')->user()->id, 'voucher_type'=>'3']);
            //                                     })->pluck('product_stock_id')->toArray();

            $productStockIds = array_merge($productStockIds1,$productStockIds2);

        }elseif($authUser->type == 'user') { 
            $productStockIds = LedgerDetail::with('ledger')->where(['new_ledger_id' => null])
                                ->whereHas('ledger', function ($q) use ($authUser) {
                                        $q->where(['to' =>$authUser->id, 'voucher_type'=>'2']);
                                })->pluck('product_stock_id')->toArray();
        }
       
        $products = Product::select('id','alias','name')->get();
        $grades = ProductMGrade::select('id','alias','grade')->get();
        $rattis = ProductMWeightRange::select('id','rati_standard')->get();

        $data = InvoiceDetailGradeProduct::whereIn('id',$productStockIds)
                                        ->select(['id','product_id','grade_id','ratti_id'])
                                        ->get()
                                        ->groupBy(['product_id','grade_id','ratti_id']);
         if(count($data) == 0){
          return view('store.StockReport.ManagerStockReport.empty');
         }

        return view('store.StockReport.ManagerStockReport.allTransactions',compact(
            'productStockIds',
            'products',
            'data',
            'managerId',
            'grades',
            'rattis',
        ));

        
    }

    public function details($id)
    {   
        $ledger = ManagerStockLedger::with('ledgerDetails')->where('id',$id)->first(); 
        return view('store.StockReport.ManagerStockReport.stockTransactionDetails',compact('ledger'));
    }

    public function print($managerId){
            
        $products = Product::select('id','alias')->get();
        $authUser = UserStore::find($managerId);

        if($authUser->type == 'org' || $authUser->type == 'lab')
        {
            
            // $productStockIds1 = $ledgerStock = LedgerDetail::with('ledger')->where(['new_ledger_id' => null])
            //                             ->whereHas('ledger', function ($q) use ($authUser){
            //                             $q->where(['account_id' =>$authUser->id, 'voucher_type'=>'1']);
            //                             })->pluck('product_stock_id')->toArray();

            // $productStockIds2 = $ledgerStock = LedgerDetail::with('ledger')->where(['new_ledger_id' => null])
            
            //                                    ->whereHas('ledger', function ($q)use ($authUser)  {
            //                                        $q->where(['to' =>$authUser->id, 'voucher_type'=>'2']);
            //                                     })->pluck('product_stock_id')->toArray();

            // $productStockIds3 = $ledgerStock = LedgerDetail::with('ledger')->where(['new_ledger_id' => null])
            
            //                                    ->whereHas('ledger', function ($q) use ($authUser) {
            //                                        $q->where(['to' => $authUser->id, 'voucher_type'=>'3']);
            //                                     })->pluck('product_stock_id')->toArray();

            // $productStockIds = array_merge($productStockIds1,$productStockIds2,$productStockIds3);
            $productStockIds1 = $ledgerStock = LedgerDetail::with('ledger')->where(['new_ledger_id' => null])
                                        ->whereHas('ledger', function ($q) {
                                        $q->where(['account_id' =>auth('store')->user()->id, 'voucher_type'=>'1']);
                                        })->pluck('product_stock_id')->toArray();  

            $productStockIds2 = $ledgerStock = LedgerDetail::with('ledger')->where(['new_ledger_id' => null])
            
                                               ->whereHas('ledger', function ($q)  {
                                                   $q->where(['to' =>auth('store')->user()->id])->whereIn('voucher_type',[2,3,4]);
                                                })->pluck('product_stock_id')->toArray();

            // $productStockIds3 = $ledgerStock = LedgerDetail::with('ledger')->where(['new_ledger_id' => null])
            
            //                                    ->whereHas('ledger', function ($q)  {
            //                                        $q->where(['to' =>auth('store')->user()->id, 'voucher_type'=>'3']);
            //                                     })->pluck('product_stock_id')->toArray();

            $productStockIds = array_merge($productStockIds1,$productStockIds2);

        }elseif($authUser->type == 'user') {
            $productStockIds = LedgerDetail::with('ledger')->where(['new_ledger_id' => null])
                                ->whereHas('ledger', function ($q) use ($authUser) {
                                        $q->where(['to' =>$authUser->id, 'voucher_type'=>'2']);
                                })->pluck('product_stock_id')->toArray();
        }  
        $totalProducts = count($productStockIds);

        $data = InvoiceDetailGradeProduct::whereIn('id',$productStockIds)->select(['id','product_id','grade_id','ratti_id'])->get()->groupBy(['product_id','grade_id','ratti_id']); 
        $data2 = InvoiceDetailGradeProduct::whereIn('id',$productStockIds)->select(['id','product_id','ratti_id'])->get()->groupBy(['product_id','ratti_id']); 
        return view('store.StockReport.ManagerStockReport.print',compact( 
            'productStockIds', 
            'products',
            'data',
            'authUser',
            'totalProducts',
            'data2'
        ));
    }

    public function printSelected(Request $request)
    {
        
        // dd($request->alL());
        $managerId = $request->managerId; 
        if($request->has('products')){
            $products = Product::whereIn('id',$request->products)->select('id','alias')->get();
        }else{
            $products = Product::select('id','alias')->get();
        }
        // dd($products);
        $authUser = UserStore::find($managerId);

        if($authUser->type == 'org' || $authUser->type == 'lab')
        {
            
            // $productStockIds1 = $ledgerStock = LedgerDetail::with('ledger')->where(['new_ledger_id' => null])
            //                             ->whereHas('ledger', function ($q) use ($authUser){
            //                             $q->where(['account_id' =>$authUser->id, 'voucher_type'=>'1']);
            //                             })->pluck('product_stock_id')->toArray();

            // $productStockIds2 = $ledgerStock = LedgerDetail::with('ledger')->where(['new_ledger_id' => null])
            
            //                                    ->whereHas('ledger', function ($q)use ($authUser)  {
            //                                        $q->where(['to' =>$authUser->id, 'voucher_type'=>'2']);
            //                                     })->pluck('product_stock_id')->toArray();

            // $productStockIds3 = $ledgerStock = LedgerDetail::with('ledger')->where(['new_ledger_id' => null])
            
            //                                    ->whereHas('ledger', function ($q) use ($authUser) {
            //                                        $q->where(['to' => $authUser->id, 'voucher_type'=>'3']);
            //                                     })->pluck('product_stock_id')->toArray();

            // $productStockIds = array_merge($productStockIds1,$productStockIds2,$productStockIds3);
            $productStockIds1 = $ledgerStock = LedgerDetail::with('ledger')->where(['new_ledger_id' => null])
                                        ->whereHas('ledger', function ($q) {
                                        $q->where(['account_id' =>auth('store')->user()->id, 'voucher_type'=>'1']);
                                        })->pluck('product_stock_id')->toArray();  

            $productStockIds2 = $ledgerStock = LedgerDetail::with('ledger')->where(['new_ledger_id' => null])
            
                                               ->whereHas('ledger', function ($q)  {
                                                   $q->where(['to' =>auth('store')->user()->id])->whereIn('voucher_type',[2,3,4]);
                                                })->pluck('product_stock_id')->toArray();

            // $productStockIds3 = $ledgerStock = LedgerDetail::with('ledger')->where(['new_ledger_id' => null])
            
            //                                    ->whereHas('ledger', function ($q)  {
            //                                        $q->where(['to' =>auth('store')->user()->id, 'voucher_type'=>'3']);
            //                                     })->pluck('product_stock_id')->toArray();

            $productStockIds = array_merge($productStockIds1,$productStockIds2);

        }elseif($authUser->type == 'user') {
            $productStockIds = LedgerDetail::with('ledger')->where(['new_ledger_id' => null])
                                ->whereHas('ledger', function ($q) use ($authUser) {
                                        $q->where(['to' =>$authUser->id, 'voucher_type'=>'2']);
                                })->pluck('product_stock_id')->toArray();
        }  
        $totalProducts = count($productStockIds);

        $data = InvoiceDetailGradeProduct::whereIn('id',$productStockIds)->select(['id','product_id','grade_id','ratti_id'])->get()->groupBy(['product_id','grade_id','ratti_id']); 
        $data2 = InvoiceDetailGradeProduct::whereIn('id',$productStockIds)->select(['id','product_id','ratti_id'])->get()->groupBy(['product_id','ratti_id']); 
        return view('store.StockReport.ManagerStockReport.print',compact( 
            'productStockIds', 
            'products',
            'data',
            'authUser',
            'totalProducts',
            'data2'
        ));
    }
    
}
