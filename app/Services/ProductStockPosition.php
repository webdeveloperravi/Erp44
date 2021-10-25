<?php
namespace App\Services;

use App\Helpers\StoreHelper;
use App\Model\Guard\UserStore;
use App\Model\Store\LedgerDetail;
use App\Model\Warehouse\InvoiceDetailGradeProduct;

class ProductStockPosition{
    
    public static function getStoreAccountIds($userId)
    {    
        $storeId = StoreHelper::getUserStoreId($userId);
        $ids =  UserStore::where('org_id',$storeId)->whereIn('type',['user'])->pluck('id')->toArray();
        return $ids;
        // return array_merge($ids,[$storeId]); 
    }

    public static function getStoreManagers($userId)
    {
        return UserStore::whereIn('id',Self::getStoreAccountIds($userId))->get();
    }

    public static function getStoreStockPosition()
    {
        
    }

    public static function getUserStockPosition($userId,$request)
    {    
        $authUser = UserStore::find($userId);

        if($authUser->type == 'org' || $authUser->type == 'lab')
        {
            
            // $productStockIds1 = $ledgerStock = LedgerDetail::with('ledger')->where(['new_ledger_id' => null])
            //                             ->whereHas('ledger', function ($q) use ($authUser){
            //                             $q->where(['account_id' =>$authUser->id, 'voucher_type'=>'1']);
            //                             })->pluck('product_stock_id')->toArray();

            // $productStockIds2 = $ledgerStock = LedgerDetail::with('ledger')->where(['new_ledger_id' => null])
            
            //                                    ->whereHas('ledger', function ($q)  use ($authUser){
            //                                        $q->where(['to' =>$authUser->id, 'voucher_type'=>'2']);
            //                                     })->pluck('product_stock_id')->toArray();

            // $productStockIds3 = $ledgerStock = LedgerDetail::with('ledger')->where(['new_ledger_id' => null])
            
            //                                    ->whereHas('ledger', function ($q)  use ($authUser){
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
                                ->whereHas('ledger', function ($q) use ($authUser) {
                                        $q->where(['to' =>$authUser->id, 'voucher_type'=>'2']);
                                })->pluck('product_stock_id')->toArray();
        }  

        if(!isset($request['grade'])){
            $request['product'] = 0;
            $request['grade'] = 0;
            $request['ratti'] = 0;
            $request['color'] = 0;
            $request['clarity'] = 0;
            $request['shape'] = 0;
            $request['origin'] = 0;
        }

        



        $count =  InvoiceDetailGradeProduct::select('id','gin','product_id','grade_id','ratti_id')
                                                ->with('product','productGrade','ratti') 
                                                ->when($request['product'] != 0 , function($query) use ($request) {
                                                        $query->where('product_id',$request['product']);
                                                })
                                                ->when($request['grade'] != 0 , function($query) use ($request) {
                                                        $query->where('grade_id',$request['grade']);
                                                })
                                                ->when($request['ratti'] != 0 , function($query) use ($request) {
                                                        $query->where('ratti_id',$request['ratti']);
                                                })
                                                ->when($request['color'] != 0 , function($query) use ($request) {
                                                        $query->where('color_id',$request['color']);
                                                })
                                                ->when($request['clarity'] != 0 , function($query) use ($request) {
                                                        $query->where('clarity_id',$request['clarity']);
                                                })
                                                ->when($request['shape'] != 0 , function($query) use ($request) {
                                                        $query->where('shape_id',$request['shape']);
                                                })
                                                ->when($request['origin'] != 0 , function($query) use ($request) {
                                                        $query->where('origin_id',$request['origin']);
                                                })
                                                ->whereIn('id',$productStockIds)
                                                ->count();  
        if($count > 0){
            return $result= ['show'=>true,'count' => $count];
        }else{
            return $result= ['show'=>false];
        }
    }

}