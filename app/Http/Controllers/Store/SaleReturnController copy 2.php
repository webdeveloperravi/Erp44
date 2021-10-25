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
        return view('store.SaleReturn.index');
    }

    public function create()
    {   
        return view('store.SaleReturn.create');
    }

    public function getStores()
    {
        $myStoreId = \App\Helpers\Helper::getStoreId(); 
        $zoneIds = StoreZone::where('store_id',$myStoreId)->pluck('zone_id')->toArray();
        $zoneCities = ZoneCity::whereIn('zone_id',$zoneIds)->pluck('city_id')->toArray(); 
        $accounts = UserStore::whereHas('addresses',function($q) use ($zoneCities){
          $q->where('address_type_id',1)->whereIn('city_id',$zoneCities);
          })->where('type','org')->orWhere('type','lab')
        ->get() 
          ;  
        return response()->json(['stores'=> $accounts]);
    }
    
    public function getAccounts($accountId)
    { 
        $managers = UserStore::select('id','name')
                       ->where(['org_id' => $accountId, 'type' => 'user'])
                       ->orWhere('id',$accountId)
                       ->where('id','!=',auth('store')->user()->id)
                       ->get() ;
        
        return response()->json(['accounts'=> $managers]); 
    }

    public function saveGins(Request $request)
    {      
        $gins = collect($request->gins);
        $notInStockProductsSaleReturn = [];
        $notExistProductsSaleReturn = [];
        foreach ($gins as $gin) {
            $response = $this->saveGin($gin); 
            if ($response == 'Not In Stock') {
                $notInStockProductsSaleReturn[] = ['gin' => $gin];
            }
            if ($response == 'Not Exist') {

                $notExistProductsSaleReturn[] = ['gin' => $gin];
            }
        };
        $notExistProductsSaleReturn = collect($notExistProductsSaleReturn)->pluck('gin')->toArray();
        $notInStockProductsSaleReturn = collect($notInStockProductsSaleReturn)->pluck('gin')->toArray();
        Session::put('notExistProductsSaleReturn', $notExistProductsSaleReturn);
        Session::put('notInStockProductsSaleReturn', $notInStockProductsSaleReturn);
    } 

    public function saveGin($gin)
    {   
        $gin = $gin['gin'];
        $getGin = $this->isProductInStock($gin);  
        if ($getGin == "Invalid") {
            return 'Not Exist';
        }   
        if ($getGin == false) { 
            return 'Not In Stock';
        }

        if($getGin->gin == $gin){
            $productStock = InvoiceDetailGradeProduct::query()
            ->with('productGrade:id,alias', 'product:id,name', 'ratti:id,rati_standard,rati_big')
            ->select('id', 'gin', 'product_id', 'product_category_id', 'grade_id', 'ratti_id', 'weight', 'in_stock')
            ->where(['gin' => $getGin->gin])
            ->first() ?? false;
            $saleReturnSession = Session::get('saleReturn');
            if (!$saleReturnSession) {
                return $this->setSessionEmptty($productStock);
            }
            if (isset($saleReturnSession[$productStock->id])) {
                return 'Product Already Added';
            }
            $productRate = $this->getProductGradeRatti($productStock);
            $saleReturnSession[$productStock->id] = [
                'id' => $productStock->id,
                'gin' => $productStock->gin,
                'product' => $productStock->product->name,
                'grade' => $productStock->productGrade->alias ?? '',
                'ratti' => $productStock->ratti->rati_standard ?? "",
                'exactRatti' => $productRate['excactRatti'],
                'exactRate' => $productRate['exactRattiRate'],
                'exactAmount' => $productRate['amount']
            ];
            Session::put('saleReturn', $saleReturnSession); 
        }
    }
 
    public function getAllDetails()
    {  
        return response()->json([
            'notInStockProductsSaleReturn' =>Session::get('notInStockProductsSaleReturn'),
            'notExistProductsSaleReturn'=> Session::get('notExistProductsSaleReturn'),
            'validProducts'=> Session::get('saleReturn'),
        ]);
    }

    public function isProductInStock($gin)
    {  
         
        if(!InvoiceDetailGradeProduct::where('gin',$gin)->first() ?? false){
            return "Invalid";
        } 

        $authUser = UserStore::find(auth('store')->user()->id);
        if($authUser->type = 'org' || $authUser->type == 'lab')
        {
            if( $ledgerStock = LedgerDetail::with('ledger')->where(['gin' => $gin, 'new_ledger_id' => null])
                      ->whereHas('ledger', function ($q) {
                         $q->where(['to' =>auth('store')->user()->id, 'voucher_type'=>'3']);
                       })->first() ?? false ){
              return $ledgerStock;
            } else{
                return false;
            } 
        }else{
            $ledgerStock = LedgerDetail::with('ledger')
                         ->where(['gin' => $gin, 'new_ledger_id' => null])
                         ->whereHas('ledger', function ($q)  {
                                 $q->where(['to' =>Helper::getStoreId(), 'voucher_type'=>'3']);
                             })->first() ?? false;
            return $ledgerStock;
        }
    }

    public function setSessionEmptty($productStock)
    {
        $productRate = $this->getProductGradeRatti($productStock);

        $saleReturnSession = [
            $productStock->id => [
                'id' => $productStock->id,
                'gin' => $productStock->gin,
                'product' => $productStock->product->name,
                'grade' => $productStock->productGrade->alias ?? '',
                'ratti' => $productStock->ratti->rati_standard ?? "",
                'exactRatti' => $productRate['excactRatti'],
                'exactRate' => $productRate['exactRattiRate'],
                'exactAmount' => $productRate['amount']
            ]
        ];
        Session::put('saleReturn', $saleReturnSession);
        return 'Success';
    }

    public function getProductGradeRatti($productStock)
    {
        $productRateProfile = Helper::getRateProfile($productStock->product_id, $productStock->grade_id);
        $productRate = Helper::getCalculateWeight($productStock->weight, $productRateProfile);
        return $productRate;
    }


    //Remove Product From Session
    public function delete($id)
    {
        $return = Session::get('saleReturn');
        if (isset($return[$id]))
        {
            unset($return[$id]);
            Session::put('saleReturn', $return);
        }
        return response()->json(['success' => true]);
    }

    public function save(Request $request)
    {       
        $validator = Validator::make($request->all(),[
            'store' => 'required|not_in:0',
            'account' => 'required|not_in:0',
            'comment' => 'required',
        ]);
        if($validator->passes()){

        $saleReturn = Session::get('saleReturn');
        $amount = collect($saleReturn)->pluck('exactAmount')->all();
        $total_amount = $this->getTotalAmount($amount);

        $ledger = Ledger::create([
            'guard_id_from' => auth('store')->user()->guard_id,
            'guard_id_to' => auth('store')->user()->guard_id,
            'voucher_type' => '2',
            'voucher_number' => $this->getSaleReturnVoucherNumber(),
            'account_id' =>  Helper::getStoreId(),
            'from' => auth('store')->user()->id,
            'to' => $request->account,
            'comment' => $request->comment,
            'status' => '1',
            'qty_total' => count(Session::get('saleReturn')) ?? 0,
            'amount_total' => $total_amount,
        ]);

        foreach (Session::get('saleReturn') as $id => $product) {
            LedgerDetail::create([
                'ledger_id' => $ledger->id,
                'product_stock_id' => $id,
                'gin' => $product['gin'],
                'product_unit_qty' => $product['exactRatti'],
                'product_unit_rate' => $product['exactRate'],
                'product_amount' => $product['exactAmount'],
                'ledger_status' => 1
            ]);
            LedgerDetail::where('id', LedgerDetail::where(['gin'=>$product['gin'],'new_ledger_id'=>null])->first()->id)->update(['new_ledger_id' => $ledger->id]);
        }
        Session::forget('saleReturn');
        Session::forget('notExistProductsSaleReturn');
        Session::forget('notInStockProductsSaleReturn');
        return response()->json(['redirectUrl'=> route('saleOrderReturn.index')]);
    }else{
        $keys = $validator->errors()->keys();
        $vals  = $validator->errors()->all();
        $errors = array_combine($keys,$vals);
       return response()->json(['errors'=>$errors],422);
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
   
    public function allReturns()
    {
        $saleReturns = Ledger::with(['userIssue', 'userReceipt'])->
                                 where('voucher_type','4')
                                ->where('from', auth('store')->user()->id)->latest()->get(); 
        return view('store.SaleReturn.all', compact('saleReturns'));
    }

    public function saleReturnDetail($id)
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

    public  function issueReturnAll(){
        $authUser = UserStore::find(auth('store')->user()->id);

        if($authUser->type == 'lab' || $authUser->type == 'org'){
           
            $userId = Helper::getStoreId();
            $managerIds = UserStore::where(['org_id'=>$userId,'type'=>'user'])->pluck('id')->toArray(); 
            $saleReturns  = Ledger::with(['userIssue', 'userReceipt'])->whereIn('from',$managerIds)->where('voucher_type','2')->orderBy('id','desc')->get();

        }elseif($authUser->type == 'user'){
            
         $managerIds = Helper::getSubRolesManagerIds();  
                                   
        $saleReturns  = Ledger::with(['userIssue', 'userReceipt'])->whereIn('from',$managerIds)->where('voucher_type','2')->orderBy('id','desc')->get(); 


        }
        return view('store.SaleReturn.issueReturnAll.all',compact('saleReturns'));
       
       
     }
     
     public function issueReturnDetail($id)
     {      
           $issueReturnDetail = Ledger::with('ledgerDetails')->where('id', $id)->first();
           return view('store.SaleReturn.issueReturnAll.issueReturnDetail', compact('issueReturnDetail'));
     }
     
    public function receiveReturnAll(){
        
        $authUser = UserStore::find(auth('store')->user()->id);

        if($authUser->type == 'lab' || $authUser->type == 'org'){
           
            $userId = Helper::getStoreId();
            $managerIds = UserStore::where(['org_id'=>$userId,'type'=>'user'])->pluck('id')->toArray(); 
            $receiveReturns  = Ledger::with(['userIssue', 'userReceipt'])->whereIn('to',$managerIds)->where('voucher_type','2')->orderBy('id','desc')->get();

        }elseif($authUser->type == 'user'){
            
         $managerIds = Helper::getSubRolesManagerIds();  
                                   
        $receiveReturns  = Ledger::with(['userIssue', 'userReceipt'])->whereIn('to',$managerIds)->where('voucher_type','2')->orderBy('id','desc')->get(); 

        } 
        return view('store.SaleReturn.receiveReturnAll.all',compact('receiveReturns'));   
    
    }
      
    public function receiveReturnDetail($id)
    {      
          $receiveReturnDetail = Ledger::with('ledgerDetails')->where('id', $id)->first();
          return view('store.SaleReturn.receiveReturnAll.receiveReturnDetail', compact('receiveReturnDetail'));
    }

    

    // public function saveReturnDetails(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //                 'gin' => 'required', 
    //                 'account' => 'required|not_in:0', 
    //                 'manager' => 'required|not_in:0',
    //                 ]);    
    //     if ($validator->passes())
    //     {
    //         $ledgerStock = $this->isProductInStock($request);
    //         if ($ledgerStock)
    //         {
    //             $return = Session::get('return');
    //             if (!$return)
    //             {
    //             $return = [$ledgerStock->id => [
    //                      'gin' => $ledgerStock->gin, 
    //                      'productStockId' => $ledgerStock->product_stock_id, 
    //                      'product'  => $ledgerStock->productStock->product->name, 
    //                      'grade' => $ledgerStock->productStock->productGrade->grade, 
    //                      'ratti' => $ledgerStock->productStock->ratti->rati_standard, 
    //                      'exactRatti' => $ledgerStock->product_unit_qty, 
    //                      'exactRattiRate' => $ledgerStock->product_unit_rate, 
    //                      'productAmount' => $ledgerStock->product_amount
    //                      ]];
    //                 Session::put('return', $return);
    //                 return response()->json(['success' => true, 'msg' => "Product Inserted Success"]);
    //             }
    //             elseif (isset($return[$ledgerStock->id]))
    //             {
    //                 return response()->json(['exist' => true, 'msg' => 'Product Already Added']);
    //             }
    //             $return[$ledgerStock->id] = ['gin' => $ledgerStock->gin, 'productStockId' => $ledgerStock->product_stock_id, 'product' => $ledgerStock
    //                 ->productStock
    //                 ->product->name, 'grade' => $ledgerStock
    //                 ->productStock
    //                 ->productGrade->grade, 'ratti' => $ledgerStock
    //                 ->productStock
    //                 ->ratti->rati_standard, 'exactRatti' => $ledgerStock->product_unit_qty, 'exactRattiRate' => $ledgerStock->product_unit_rate, 'productAmount' => $ledgerStock->product_amount];
    //             Session::put('return', $return);

    //             return response()->json(['success' => true, 'msg' => "Product Inserted Success"]);
    //         }else
    //         {
    //           return response()->json(['success' => false, 'msg' => "GIN Does Not Exists"]);
    //         }
    //     }else
    //     {
    //         $keys = $validator->errors() ->keys();
    //         $vals = $validator->errors() ->all();
    //         $errors = array_combine($keys, $vals);
    //         return response()->json(['errors' => $errors]);
    //     }

    // }

    // public function getReturnDetails()
    // {

    //     $collection = Session::get('return');
    //     $returnData = Session::get('return');

    //     $arrayData = collect($returnData)->pluck('productAmount')
    //         ->all();

    //     $total_amount = $this->getTotalAmount($arrayData);
    //     return view('store.SaleReturn.allProducts', compact('collection', 'total_amount'));
    // }

}
