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
use App\Model\Store\StoreSaleOrder;
use App\Http\Controllers\Controller;
use App\Model\Store\StorePurchaseOrder;
use Illuminate\Support\Facades\Validator;
use App\Model\Admin\Organization\ZoneCity;
use App\Model\Store\StoreSaleOrderChallan;
use App\Model\Store\StorePurchaseOrderDetail;
use App\Model\Admin\Organization\StoreAddress;
use App\Model\Warehouse\InvoiceDetailGradeProduct;

class ReceiveChallanController extends Controller
{   
    
    public function index()
    {   
        // Session::forget('receiveChallan');
        // Session::forget('userId');
        // dd(Session::get('receiveChallan'));
        return view('store.ReceiveChallan.index');
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
        return view('store.ReceiveChallan.create', compact('accounts'));
    }

    public function getManagers($accountId)
    {
        $managers = UserStore::select('id','name')->where(['org_id' => $accountId, 'type' => 'user'])->orWhere('id',$accountId)->get(); 
        return view('store.ReceiveChallan.managerList', compact('managers','accountId'));
    }

    public function saveChallanDetails(Request $request)
    {   
        
        $validator = Validator::make($request->all(), [
                    'gin' => 'required', 
                    'manager' => 'required|not_in:0',
                
                    ]);    
        if ($validator->passes())
        {
            $ledgerStock = $this->isProductInStock($request);
            if ($ledgerStock)
            {   
                $challan = Session::get('receiveChallan') && Session::get('userId') == $request->manager;
                if (!$challan)
                {
                Session::forget('receiveChallan');
                Session::forget('userId');
                $challan = [$ledgerStock->id => [
                         'gin' => $ledgerStock->gin, 
                         'productStockId' => $ledgerStock->product_stock_id, 
                         'product'  => $ledgerStock->productStock->product->name, 
                         'grade' => $ledgerStock->productStock->productGrade->grade, 
                         'ratti' => $ledgerStock->productStock->ratti->rati_standard, 
                         'exactRatti' => $ledgerStock->product_unit_qty, 
                         'exactRattiRate' => $ledgerStock->product_unit_rate, 
                         'productAmount' => $ledgerStock->product_amount
                         ]];
                Session::put('receiveChallan', $challan);
                Session::put('userId',$request->manager);
                    return response()->json(['success' => true, 'msg' => "Product Inserted Success"]);
                }
                elseif (isset($challan[$ledgerStock->id]))
                {
                    return response()->json(['exist' => true, 'msg' => 'Product Already Added']);
                }else{
                    
                    $challan[$ledgerStock->id] = ['gin' => $ledgerStock->gin, 'productStockId' => $ledgerStock->product_stock_id, 'product' => $ledgerStock
                        ->productStock
                        ->product->name, 'grade' => $ledgerStock
                        ->productStock
                        ->productGrade->grade, 'ratti' => $ledgerStock
                        ->productStock
                        ->ratti->rati_standard, 'exactRatti' => $ledgerStock->product_unit_qty, 'exactRattiRate' => $ledgerStock->product_unit_rate, 'productAmount' => $ledgerStock->product_amount];
                    Session::put('receiveChallan', $challan);
    
                    return response()->json(['success' => true, 'msg' => "Product Inserted Success"]);
                }
            }else
            {
              return response()->json(['success' => false, 'msg' => "GIN Does Not Exists"]);
            }
        }else
        {
            $keys = $validator->errors() ->keys();
            $vals = $validator->errors() ->all();
            $errors = array_combine($keys, $vals);
            return response()->json(['errors' => $errors]);
        }

    }

    public function getChallanDetails()
    {

        $collection = Session::get('receiveChallan');
        $challanData = Session::get('receiveChallan');

        $arrayData = collect($challanData)->pluck('productAmount')
            ->all();

        $total_amount = $this->getTotalAmount($arrayData);
        return view('store.ReceiveChallan.allProducts', compact('collection', 'total_amount'));
    }

    //Remove Product From Session
    public function removeDetail($id)
    {   
        $challan = Session::get('receiveChallan');
        if (isset($challan[$id]))
        {
            unset($challan[$id]);
            Session::put('receiveChallan', $challan);
        }
        return response()->json(['success' => true]);
    }

    public function save(Request $request)
    { 
          $validator = Validator::make($request->all() , [
                // 'credit_to' => 'required|not_in:0',
                    // 'account' => 'required|not_in:0', 
                    'manager' => 'required|not_in:0',
                 ]);

        $challanData = Session::get('receiveChallan');
        $arrayData = collect($challanData)->pluck('productAmount')->all();
       
        if ($validator->passes())
        {
            $voucherTypeId ='2';
            $debitorVoucherNumber = $this->getSaleChallanVoucherNumber();
            $ledger = Ledger::create([
                'guard_id_from' => auth('store')->user()->guard_id,
                'guard_id_to' => auth('store')->user()->guard_id,
                'voucher_type' => $voucherTypeId,
                'voucher_number' => $debitorVoucherNumber,
                'account_id' =>  Helper::getUserStoreId($request->manager),
                'from' => $request->manager,
                'to' => auth('store')->user()->id,
                'qty_total' => count(Session::get('receiveChallan')) ,
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

         foreach (Session::get('receiveChallan') as $id => $product)
            {

                LedgerDetail::create(['ledger_id' => $ledger->id, 'product_stock_id' => $product['productStockId'], 'gin' => $product['gin'], 'product_unit_qty' => $product['exactRatti'], 'product_unit_rate' => $product['exactRattiRate'], 'product_amount' => $product['productAmount'], 'ledger_status' => 1

                ]);

                LedgerDetail::where(['id' => $id])->update(['new_ledger_id' => $ledger->id]);

            }

            Session::forget('receiveChallan');
            return response()
                ->json(['success' => true, 'msg' => "Challan Successfully Created.{{$debitorVoucherNumber}}", 'challanNumber' => $debitorVoucherNumber]);
    }
   
    public function all()
    {
        $saleChallans = Ledger::with(['userIssue', 'userReceipt'])->
                                 where('voucher_type','2')
                                ->where('to', auth('store')->user()->id)->latest()->get(); 
     
                                return view('store.ReceiveChallan.all', compact('saleChallans'));
    }

    public function receiveChallanDetail($id)
    {
        $parentStoreId = auth('store')->user()->parentStore->id ?? null; 
       if($parentStoreId == null)
       {
        $saleChallan = Ledger::where(['account_id' => auth('store')->user()->id, 'id' => $id])->first();
       }
       else{
         $saleChallan = Ledger::where(['to' => auth('store')->user()->id, 'id' => $id])->first();
       }

       return view('store.ReceiveChallan.receivedChallanDetail', compact('saleChallan'));
    }

    // public function receivedChallans()
    // {
    //     $receivedChallans = Ledger::where(['to' => auth('store')->user()
    //         ->id])
    //         ->orderBy('id', 'Desc')
    //         ->get();
    //     return view('store.ReceiveChallan.receivedChallans', compact('receivedChallans'));
    // }

    // public function receivedChallanDetails($id)
    // {
        
    //     $receivedChallan = Ledger::where(['to' => auth('store')->user()->id, 'id' => $id])->first(); 
    //     return view('store.ReceiveChallan.receivedChallanDetail', compact('receivedChallan'));

    // }

    // public function view($id)
    // {
    //     $saleChallan = Ledger::find($id);
    //     return view('store.ReceiveChallan.view', compact('saleChallan'));
    // }

    

    

    public function isProductInStock(Request $request)
    {
       $authUser = UserStore::find($request->manager);
       if($authUser->type = 'org' || $authUser->type == 'lab')
       {
           if( $ledgerStock = LedgerDetail::with('ledger')->where(['gin' => $request->gin, 'new_ledger_id' => null])
                     ->whereHas('ledger', function ($q) use ($authUser) {
                        $q->where(['account_id' => $authUser->id, 'voucher_type'=>'1']);
                      })->first() ?? false ){
             return $ledgerStock;
           }
           elseif( $ledgerStock = LedgerDetail::with('ledger')
                                ->where(['gin' => $request->gin, 'new_ledger_id' => null])
                                ->whereHas('ledger', function ($q) use ($authUser) {
                                         $q->where(['to' =>$authUser->id, 'voucher_type'=>'2']);
                                })->first() ?? false){
                return $ledgerStock;
           } else
           {
                return false;
           }
       } elseif($authUser->type = 'user'){
           $ledgerStock = LedgerDetail::with('ledger')
                        ->where(['gin' => $request->gin, 'new_ledger_id' => null])
                        ->whereHas('ledger', function ($q) use ($authUser) {
                                $q->where(['to' =>$authUser->id, 'voucher_type'=>'2']);
                            })->first() ?? false;
           return $ledgerStock;
       }
    }
    

   

   public function getSaleChallanVoucherNumber(){
   $authUser = UserStore::find(auth('store')->user()->id);

    if($authUser->type == 'org' || $authUser->type == 'lab'){
 
  
       if($ledger = Ledger::where(['account_id' =>$authUser->id,'voucher_type' =>'2'])->latest()->first() ?? false)
       {
          return $ledger->voucher_number+1;

       }else{
          return 1001;
       }
    }else{

        if($ledger = Ledger::where(['account_id' =>$authUser->parentStore->id,'voucher_type' =>'2'])->latest()->first() ?? false)
        {
             return $ledger->voucher_number+1;
        }else{
            return 1001;
        }
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

    

    public  function issueChallanAll(){
        $authUser = UserStore::find(auth('store')->user()->id);

        if($authUser->type == 'lab' || $authUser->type == 'org'){
           
            $userId = Helper::getStoreId();
            $managerIds = UserStore::where(['org_id'=>$userId,'type'=>'user'])->pluck('id')->toArray(); 
            $saleChallans  = Ledger::with(['userIssue', 'userReceipt'])->whereIn('from',$managerIds)->where('voucher_type','2')->orderBy('id','desc')->get();

        }elseif($authUser->type == 'user'){
            
         $managerIds = Helper::getSubRolesManagerIds();  
                                   
        $saleChallans  = Ledger::with(['userIssue', 'userReceipt'])->whereIn('from',$managerIds)->where('voucher_type','2')->orderBy('id','desc')->get(); 


        }
        return view('store.ReceiveChallan.issueChallanAll.all',compact('saleChallans'));
       
     }
     
     public function issueChallanDetail($id)
     {      
           $issueChallanDetail = Ledger::with('ledgerDetails')->where('id', $id)->first();
           return view('store.ReceiveChallan.issueChallanAll.issueChallanDetail', compact('issueChallanDetail'));
     }
     
    public function receiveChallanAll(){
        
        $authUser = UserStore::find(auth('store')->user()->id);

        if($authUser->type == 'lab' || $authUser->type == 'org'){
           
            $userId = Helper::getStoreId();
            $managerIds = UserStore::where(['org_id'=>$userId,'type'=>'user'])->pluck('id')->toArray(); 
            $receiveChallans  = Ledger::with(['userIssue', 'userReceipt'])->whereIn('to',$managerIds)->where('voucher_type','2')->orderBy('id','desc')->get();

        }elseif($authUser->type == 'user'){
            
         $managerIds = Helper::getSubRolesManagerIds();  
                                   
        $receiveChallans  = Ledger::with(['userIssue', 'userReceipt'])->whereIn('to',$managerIds)->where('voucher_type','2')->orderBy('id','desc')->get(); 

        } 
        return view('store.ReceiveChallan.receiveChallanAll.all',compact('receiveChallans'));   
    
    }
      
    public function receiveChallanAllDetail($id)
    {      
          $receiveChallanDetail = Ledger::with('ledgerDetails')->where('id', $id)->first();
          return view('store.ReceiveChallan.receiveChallanAll.receiveChallanDetail', compact('receiveChallanDetail'));
    }
          
}

