<?php

namespace App\Http\Controllers\Store;

use App\Helpers\Helper;
use App\Model\Store\Ledger;
use App\Helpers\StoreHelper;
use Illuminate\Http\Request;
use App\Model\Guard\UserStore;
use App\Model\Store\StoreZone;
use App\Model\Store\LedgerDetail;
use App\Model\Admin\Master\Product;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Model\Admin\Master\ProductMGrade;
use App\Model\Admin\Organization\ZoneCity;
use App\Model\Admin\Master\ProductMWeightRange;
use App\Model\Warehouse\InvoiceDetailGradeProduct;

class StockVerifyController extends Controller
{
    public function index(){
         
        $products = Product::select('id','alias')->get();
        $grades = ProductMGrade::select('id','alias')->get();
        $rattis = ProductMWeightRange::select('id','rati_standard')->get();
        $myStoreId = \App\Helpers\StoreHelper::getStoreId(); 
        $zoneIds = StoreZone::where('store_id',$myStoreId)->pluck('zone_id')->toArray();
        $zoneCities = ZoneCity::whereIn('zone_id',$zoneIds)->pluck('city_id')->toArray(); 
        $stores = UserStore::whereHas('addresses',function($q) use ($zoneCities){
          $q->where('address_type_id',1)->whereIn('city_id',$zoneCities);
          })->where('type','org')->orWhere('type','lab')
          ->with('headOfficeAddress.city:id,name')
          ->orderBy('company_name')
        ->get() 
        ; 

        return view('store.StockVerify.index',compact('products','grades','rattis','stores'));
    }
      
    public function getAccounts($accountId)
    { 
        $managers = UserStore::select('id','name')
                       ->where(['org_id' => $accountId, 'type' => 'user'])
                       ->orWhere('id',$accountId) 
                       ->orderBy('name')
                       ->get() 
                    ;
        
        return response()->json(['accounts'=> $managers]); 
    }

    public function saveGins(Request $request)
    {        
        
        // dd($request->all());
        $inStockProductGins = collect();
        $outOfStockProductGins = collect();
        $notInStockProductGins = collect();
        $invalidProducts = collect();
        
        $gins = collect($request->gins)->pluck('gin')->toArray();  
        foreach ($gins as $gin) {  
            $response = $this->getGinStatus($gin,$request->userId);  
            if ($response == 'inStock') {
                $inStockProductGins = $inStockProductGins->concat([$gin]);
            }
            if ($response == 'outOfStock') {
                $outOfStockProductGins = $outOfStockProductGins->concat([$gin]);
            }
            if ($response == 'notInStock') {
                $notInStockProductGins = $notInStockProductGins->concat([$gin]);
            }
            if ($response == 'inValid') {
                $invalidProducts = $invalidProducts->concat([$gin]);
            }
        };  

        $inStockProducts = InvoiceDetailGradeProduct::select('id','gin','product_id','grade_id','ratti_id')
                                        ->with('product','productGrade','ratti') 
                                        ->when($request->product != 0 , function($query) use ($request) {
                                                $query->where('product_id',$request->product);
                                        })
                                        ->when($request->grade != 0 , function($query) use ($request) {
                                                $query->where('grade_id',$request->grade);
                                        })
                                        ->when($request->ratti != 0 , function($query) use ($request) {
                                                $query->where('ratti_id',$request->ratti);
                                        })
                                        ->whereIn('gin',$inStockProductGins)
                                        ->get();

        $outOfStockProducts = InvoiceDetailGradeProduct::select('id','gin','product_id','grade_id','ratti_id')
                                          ->with('product','productGrade','ratti') 
                                        ->when($request->product != 0 , function($query) use ($request) {
                                                $query->where('product_id',$request->product);
                                        })
                                        ->when($request->grade != 0 , function($query) use ($request) {
                                                $query->where('grade_id',$request->grade);
                                        })
                                        ->when($request->ratti != 0 , function($query) use ($request) {
                                                $query->where('ratti_id',$request->ratti);
                                        })
                                        ->whereIn('gin',$outOfStockProductGins)
                                        ->get();

        $notInStockProducts = InvoiceDetailGradeProduct::select('id','gin','product_id','grade_id','ratti_id')
                                        ->with('product','productGrade','ratti') 
                                        ->when($request->product != 0 , function($query) use ($request) {
                                                $query->where('product_id',$request->product);
                                        })
                                        ->when($request->grade != 0 , function($query) use ($request) {
                                                $query->where('grade_id',$request->grade);
                                        })
                                        ->when($request->ratti != 0 , function($query) use ($request) {
                                                $query->where('ratti_id',$request->ratti);
                                        })
                                        ->whereIn('gin',$notInStockProductGins)
                                        ->get();

       
 
        $foundedProducts = collect([
                                $inStockProducts->pluck('gin'),
                                $outOfStockProducts->pluck('gin'),
                                $notInStockProducts->pluck('gin')
                           ])->collapse()->all();

        $differentProductGins = collect([$inStockProductGins, $outOfStockProductGins, $notInStockProductGins ])
                                ->collapse()
                                ->diff($foundedProducts); 

        $differentProducts =  InvoiceDetailGradeProduct::select('id','gin','product_id','grade_id','ratti_id')
                                ->with('product','productGrade','ratti')  
                                ->whereIn('gin',$differentProductGins)
                                ->get(); 
        if($request->wantNotScannedProducts){
            $notScannedProducts = array_diff($this->userInStockProducts($request->userId),$inStockProducts->pluck('gin')->toArray());
            $notScannedProducts =  InvoiceDetailGradeProduct::select('id','gin','product_id','grade_id','ratti_id')
                                    ->with('product','productGrade','ratti')  
                                    ->whereIn('gin',$notScannedProducts)
                                    ->get();
            $notScannedProductsShow = true;
        }else{
            $notScannedProducts = false;
            $notScannedProductsShow = false;
        }

          
 
         

        return response()->json([
            'inStockProducts' => $inStockProducts ,
            'outOfStockProducts' => $outOfStockProducts ,
            'notInStockProducts' => $notInStockProducts ,
            'invalidProducts' => $invalidProducts ,
            'differentProducts' => $differentProducts ,
            'notScannedProducts' => $notScannedProducts ,
            'notScannedProductsShow' => $notScannedProductsShow ,
        ]);
    } 



    public function getGinStatus($gin,$userId)
    {   
        
        if(!InvoiceDetailGradeProduct::where('gin',$gin)->first() ?? false){
            return "inValid";
        }
        
        $authUser = UserStore::find($userId);
        if($authUser->type == 'org' || $authUser->type == 'lab')
        {    
            //InStock
            if(LedgerDetail::with('ledger')->where(['gin' => $gin, 'new_ledger_id' => null])
                      ->whereHas('ledger', function ($q) use($authUser){
                         $q->where(['account_id' =>$authUser->id, 'voucher_type'=>'1']); })->first() ?? false ){
              return 'inStock';

            }elseif(LedgerDetail::with('ledger')
                                 ->where(['gin' => $gin, 'new_ledger_id' => null])
                                 ->whereHas('ledger', function ($q) use($authUser) {
                                          $q->where(['to' =>$authUser->id, 'voucher_type'=>'2']);
                                 })->first() ?? false){
                return 'inStock';

            }elseif( $ledgerStock = LedgerDetail::with('ledger')
                                 ->where(['gin' => $gin, 'new_ledger_id' => null])
                                 ->whereHas('ledger', function ($q) use($authUser) {
                                          $q->where(['to' =>$authUser->id, 'voucher_type'=>'3']);
                                 })->first() ?? false){
                return 'inStock';
            }
            //Out Of Stock
            if(LedgerDetail::with('ledger')->where(['gin' => $gin])
                      ->where('new_ledger_id','!=',null)
                      ->whereHas('ledger', function ($q) use($authUser){
                          $q->where(['account_id' =>$authUser->id, 'voucher_type'=>'1']);
                       })->first() ?? false ){
              return 'outOfStock';

            }elseif(LedgerDetail::with('ledger')
                                 ->where(['gin' => $gin])
                                 ->where('new_ledger_id','!=',null)
                                 ->whereHas('ledger', function ($q) use($authUser) {
                                          $q->where(['to' =>$authUser->id, 'voucher_type'=>'2']);
                                 })->first() ?? false){
                return 'outOfStock';

            }elseif( $ledgerStock = LedgerDetail::with('ledger')
                                 ->where(['gin' => $gin])
                                 ->where('new_ledger_id','!=',null)
                                 ->whereHas('ledger', function ($q) use($authUser) {
                                          $q->where(['to' =>$authUser->id, 'voucher_type'=>'3']);
                                 })->first() ?? false){
                return 'outOfStock';
            }else{
                return 'notInStock';
            }
        }else{
            //In Stock
            if(LedgerDetail::with('ledger')
                            ->where(['gin' => $gin, 'new_ledger_id' => null])
                            ->whereHas('ledger', function ($q) use($authUser) {
                                    $q->where(['to' =>$authUser->id, 'voucher_type'=>'2']);
                                })->first() ?? false){
              return 'inStock';
            
            }elseif(LedgerDetail::with('ledger')
                            ->where(['gin' => $gin])
                            ->where('new_ledger_id','!=',null)
                            ->whereHas('ledger', function ($q) use($authUser) {
                                    $q->where(['to' =>$authUser->id, 'voucher_type'=>'2']);
                                })->first() ?? false){
                return 'outOfStock';
            }else{
                return 'notInStock';
            }
        }
    } 

    public function getProducts(Request $request)
    {        
        
        $authUser = UserStore::find($request->userId);

        if($authUser->type == 'org' || $authUser->type == 'lab')
        {
            
            // $productStockIds1 = $ledgerStock = LedgerDetail::with('ledger')->where(['new_ledger_id' => null])
            //                             ->whereHas('ledger', function ($q) use($authUser){
            //                             $q->where(['account_id' =>$authUser->id, 'voucher_type'=>'1']);
            //                             })->pluck('product_stock_id')->toArray();

            // $productStockIds2 = $ledgerStock = LedgerDetail::with('ledger')->where(['new_ledger_id' => null])
            
            //                                    ->whereHas('ledger', function ($q) use($authUser) {
            //                                        $q->where(['to' =>$authUser->id, 'voucher_type'=>'2']);
            //                                     })->pluck('product_stock_id')->toArray();

            // $productStockIds3 = $ledgerStock = LedgerDetail::with('ledger')->where(['new_ledger_id' => null])
            
            //                                    ->whereHas('ledger', function ($q) use($authUser) {
            //                                        $q->where(['to' =>$authUser->id, 'voucher_type'=>'3']);
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
                                ->whereHas('ledger', function ($q) use($authUser) {
                                        $q->where(['to' =>$authUser->id, 'voucher_type'=>'2']);
                                    })->pluck('product_stock_id')->toArray();
        }

        $gins = InvoiceDetailGradeProduct::select('id','gin','product_id','grade_id','ratti_id') 
                                                ->when($request->product != 0 , function($query) use ($request) {
                                                        $query->where('product_id',$request->product);
                                                })
                                                ->when($request->grade != 0 , function($query) use ($request) {
                                                        $query->where('grade_id',$request->grade);
                                                })
                                                ->when($request->ratti != 0 , function($query) use ($request) {
                                                        $query->where('ratti_id',$request->ratti);
                                                })
                                                ->whereIn('id',$productStockIds)
                                                ->pluck('gin')->toArray(); 

        $inStockOpeningProductGins = collect();
        $inStockApprovalProductGins = collect();
        $inStockFinalProductGins = collect();
        $outOfStockProductGins = collect();
        $notInStockProductGins = collect();
        $invalidProducts = collect();

        foreach ($gins as $gin) {  
            $response = $this->getGinStatus2($gin,$authUser->id);  
            if ($response == 'inStockOpening') {
                $inStockOpeningProductGins = $inStockOpeningProductGins->concat([$gin]);
            }
            if ($response == 'inStockApproval') {
                $inStockApprovalProductGins = $inStockApprovalProductGins->concat([$gin]);
            }
            if ($response == 'inStockFinal') {
                $inStockFinalProductGins = $inStockFinalProductGins->concat([$gin]);
            }
            if ($response == 'outOfStock') {
                $outOfStockProductGins = $outOfStockProductGins->concat([$gin]);
            }
            if ($response == 'notInStock') {
                $notInStockProductGins = $notInStockProductGins->concat([$gin]);
            }
            if ($response == 'inValid') {
                $invalidProducts = $invalidProducts->concat([$gin]);
            }
        };  

        $inStockOpeningProducts = InvoiceDetailGradeProduct::select('id','gin','product_id','grade_id','ratti_id')
                                        ->with('product','productGrade','ratti')  
                                        ->whereIn('gin',$inStockOpeningProductGins)
                                        ->get(); 

        $inStockApprovalProducts = InvoiceDetailGradeProduct::select('id','gin','product_id','grade_id','ratti_id')
                                        ->with('product','productGrade','ratti')  
                                        ->whereIn('gin',$inStockApprovalProductGins)
                                        ->get(); 

        $inStockFinalProducts = InvoiceDetailGradeProduct::select('id','gin','product_id','grade_id','ratti_id')
                                        ->with('product','productGrade','ratti')  
                                        ->whereIn('gin',$inStockFinalProductGins)
                                        ->get();

        $outOfStockProducts = InvoiceDetailGradeProduct::select('id','gin','product_id','grade_id','ratti_id')
                                        ->with('product','productGrade','ratti')  
                                        ->whereIn('gin',$outOfStockProductGins)
                                        ->get();  
        return response()->json([
            'inStockOpeningProducts' => $inStockOpeningProducts ,
            'inStockApprovalProducts' => $inStockApprovalProducts ,
            'inStockFinalProducts' => $inStockFinalProducts ,
            'outOfStockProducts' => $outOfStockProducts , 
            'invalidProducts' => $invalidProducts , 
        ]);
    }  

    
    public function getGinStatus2($gin,$userId)
    {   
        
        if(!InvoiceDetailGradeProduct::where('gin',$gin)->first() ?? false){
            return "inValid";
        }
        
        $authUser = UserStore::find($userId);
        if($authUser->type == 'org' || $authUser->type == 'lab')
        {    
            //InStock
            if(LedgerDetail::with('ledger')->where(['gin' => $gin, 'new_ledger_id' => null])
                      ->whereHas('ledger', function ($q) use($authUser){
                         $q->where(['account_id' =>$authUser->id, 'voucher_type'=>'1']); })->first() ?? false ){
              return 'inStockOpening';

            }elseif(LedgerDetail::with('ledger')
                                 ->where(['gin' => $gin, 'new_ledger_id' => null])
                                 ->whereHas('ledger', function ($q) use($authUser) {
                                          $q->where(['to' =>$authUser->id, 'voucher_type'=>'2']);
                                 })->first() ?? false){
                return 'inStockApproval';

            }elseif( $ledgerStock = LedgerDetail::with('ledger')
                                 ->where(['gin' => $gin, 'new_ledger_id' => null])
                                 ->whereHas('ledger', function ($q) use($authUser) {
                                          $q->where(['to' =>$authUser->id, 'voucher_type'=>'3']);
                                 })->first() ?? false){
                return 'inStockFinal';
            }
            //Out Of Stock
            if(LedgerDetail::with('ledger')->where(['gin' => $gin])
                      ->where('new_ledger_id','!=',null)
                      ->whereHas('ledger', function ($q) use($authUser){
                          $q->where(['account_id' =>$authUser->id, 'voucher_type'=>'1']);
                       })->first() ?? false ){
              return 'outOfStock';

            }elseif(LedgerDetail::with('ledger')
                                 ->where(['gin' => $gin])
                                 ->where('new_ledger_id','!=',null)
                                 ->whereHas('ledger', function ($q) use($authUser) {
                                          $q->where(['to' =>$authUser->id, 'voucher_type'=>'2']);
                                 })->first() ?? false){
                return 'outOfStock';

            }elseif( $ledgerStock = LedgerDetail::with('ledger')
                                 ->where(['gin' => $gin])
                                 ->where('new_ledger_id','!=',null)
                                 ->whereHas('ledger', function ($q) use($authUser) {
                                          $q->where(['to' =>$authUser->id, 'voucher_type'=>'3']);
                                 })->first() ?? false){
                return 'outOfStock';
            }else{
                return 'notInStock';
            }
        }else{
            //In Stock
            if(LedgerDetail::with('ledger')
                            ->where(['gin' => $gin, 'new_ledger_id' => null])
                            ->whereHas('ledger', function ($q) use($authUser) {
                                    $q->where(['to' =>$authUser->id, 'voucher_type'=>'2']);
                                })->first() ?? false){
              return 'inStock';
            
            }elseif(LedgerDetail::with('ledger')
                            ->where(['gin' => $gin])
                            ->where('new_ledger_id','!=',null)
                            ->whereHas('ledger', function ($q) use($authUser) {
                                    $q->where(['to' =>$authUser->id, 'voucher_type'=>'2']);
                                })->first() ?? false){
                return 'outOfStock';
            }else{
                return 'notInStock';
            }
        }
    } 




    public function userInStockProducts($userId)
    { 
        $authUser = UserStore::find($userId);

        if($authUser->type == 'org' || $authUser->type == 'lab')
        {
            
            // $productStockIds1 = $ledgerStock = LedgerDetail::with('ledger')->where(['new_ledger_id' => null])
            //                             ->whereHas('ledger', function ($q) use($authUser){
            //                             $q->where(['account_id' =>$authUser->id, 'voucher_type'=>'1']);
            //                             })->pluck('product_stock_id')->toArray();

            // $productStockIds2 = $ledgerStock = LedgerDetail::with('ledger')->where(['new_ledger_id' => null])
            
            //                                    ->whereHas('ledger', function ($q) use($authUser) {
            //                                        $q->where(['to' =>$authUser->id, 'voucher_type'=>'2']);
            //                                     })->pluck('product_stock_id')->toArray();

            // $productStockIds3 = $ledgerStock = LedgerDetail::with('ledger')->where(['new_ledger_id' => null])
            
            //                                    ->whereHas('ledger', function ($q) use($authUser) {
            //                                        $q->where(['to' =>$authUser->id, 'voucher_type'=>'3']);
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
                                ->whereHas('ledger', function ($q) use($authUser) {
                                        $q->where(['to' =>$authUser->id, 'voucher_type'=>'2']);
                                    })->pluck('product_stock_id')->toArray();
        }

        $gins = InvoiceDetailGradeProduct::select('id','gin','product_id','grade_id','ratti_id') 
                                                // ->when($request->product != 0 , function($query) use ($request) {
                                                //         $query->where('product_id',$request->product);
                                                // })
                                                // ->when($request->grade != 0 , function($query) use ($request) {
                                                //         $query->where('grade_id',$request->grade);
                                                // })
                                                // ->when($request->ratti != 0 , function($query) use ($request) {
                                                //         $query->where('ratti_id',$request->ratti);
                                                // })
                                                ->whereIn('id',$productStockIds)
                                                ->pluck('gin')->toArray(); 

        $inStockProductGins = collect();
        // $outOfStockProductGins = collect();
        // $notInStockProductGins = collect();
        // $invalidProducts = collect();
         
        foreach ($gins as $gin) {  
            $response = $this->getGinStatus($gin,$authUser->id);  
            if ($response == 'inStock') {
                $inStockProductGins = $inStockProductGins->concat([$gin]);
            }
            // if ($response == 'outOfStock') {
            //     $outOfStockProductGins = $outOfStockProductGins->concat([$gin]);
            // }
            // if ($response == 'notInStock') {
            //     $notInStockProductGins = $notInStockProductGins->concat([$gin]);
            // }
            // if ($response == 'inValid') {
            //     $invalidProducts = $invalidProducts->concat([$gin]);
            // }
        };  

        return InvoiceDetailGradeProduct::select('id','gin','product_id','grade_id','ratti_id')
                                        ->with('product','productGrade','ratti')  
                                        ->whereIn('gin',$inStockProductGins)
                                        ->pluck('gin')->toArray();

        // $outOfStockProducts = InvoiceDetailGradeProduct::select('id','gin','product_id','grade_id','ratti_id')
        //                                 ->with('product','productGrade','ratti')  
        //                                 ->whereIn('gin',$outOfStockProductGins)
        //                                 ->get(); 
 
        // return response()->json([
        //     'inStockProducts' => $inStockProducts ,
        //     'outOfStockProducts' => $outOfStockProducts , 
        //     'invalidProducts' => $invalidProducts , 
        // ]);
    }
}
