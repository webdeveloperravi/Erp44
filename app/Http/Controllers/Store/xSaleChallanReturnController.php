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

class SaleChallanReturnController extends Controller
{
    public function index()
    {
        $accounts = UserStore::select('id', 'name', 'company_name', 'type')->where('type', 'org')
            ->orWhere('type', 'lab')
            ->get();
        return view('store.SaleChallanReturn.index');
    }

    public function allChallans()
    {
        $saleChallanReturns = Ledger::with(['userIssue', 'userReceipt'])->
                                 where('voucher_type','8')
                                ->where('from', auth('store')->user()->id)->latest()->get(); 
       return view('store.SaleChallanReturn.all', compact('saleChallanReturns'));
    }

    public function preparedSaleChallanDetail($id)
    {
        $parentStoreId = auth('store')->user()->parentStore->id ?? null; 
       if($parentStoreId == null)
       {
        $saleChallanReturn = Ledger::where(['account_id' => auth('store')->user()->id, 'id' => $id])->first();
       }
       else{
         $saleChallanReturn = Ledger::where(['from' => auth('store')->user()->id, 'id' => $id])->first();
       }
       

        return view('store.SaleChallanReturn.saleChallanReturnDetail', compact('saleChallanReturn'));
    }

    // public function receivedChallans()
    // {

    //     $receivedChallans = Ledger::where(['credit_to' => auth('store')->user()
    //         ->id])
    //         ->orderBy('id', 'Desc')
    //         ->get();
    //     return view('store.SaleChallanReturn.receivedChallans', compact('receivedChallans'));

    // }

    public function receivedChallanDetails($id)
    {
        // dd('saab');
        $receivedChallan = Ledger::where(['id' => $id])->first(); 
        return view('store.SaleChallanReturn.receivedChallanDetail', compact('receivedChallan'));

    }

    public function view($id)
    {
        $saleChallanReturn = Ledger::find($id);
        return view('store.SaleChallanReturn.view', compact('saleChallanReturn'));
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
        return view('store.SaleChallanReturn.create', compact('accounts'));
    }

    public function getManagers($accountId)
    {
        $managers = UserStore::select('id','name')->where(['org_id' => $accountId, 'type' => 'user'])->orWhere('id',$accountId)->get(); 
        return view('store.SaleChallanReturn.managerList', compact('managers','accountId'));
    }

    public function saveChallanDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
                    'gin' => 'required', 
                    'account' => 'required|not_in:0', 
                    'manager' => 'required|not_in:0',
                    ]);    
        if ($validator->passes())
        {
            $ledgerStock = $this->isProductInStock($request);
            if ($ledgerStock)
            {
                $challan = Session::get('challan');
                if (!$challan)
                {
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
                    Session::put('challan', $challan);
                    return response()->json(['success' => true, 'msg' => "Product Inserted Success"]);
                }
                elseif (isset($challan[$ledgerStock->id]))
                {
                    return response()->json(['exist' => true, 'msg' => 'Product Already Added']);
                }
                $challan[$ledgerStock->id] = ['gin' => $ledgerStock->gin, 'productStockId' => $ledgerStock->product_stock_id, 'product' => $ledgerStock
                    ->productStock
                    ->product->name, 'grade' => $ledgerStock
                    ->productStock
                    ->productGrade->grade, 'ratti' => $ledgerStock
                    ->productStock
                    ->ratti->rati_standard, 'exactRatti' => $ledgerStock->product_unit_qty, 'exactRattiRate' => $ledgerStock->product_unit_rate, 'productAmount' => $ledgerStock->product_amount];
                Session::put('challan', $challan);

                return response()->json(['success' => true, 'msg' => "Product Inserted Success"]);
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

    //Remove Product From Session
    public function removeProduct($id)
    {
        $challan = Session::get('challan');
        if (isset($challan[$id]))
        {
            unset($challan[$id]);
            Session::put('challan', $challan);
        }
        return response()->json(['success' => true]);
    }

    public function saleChallanReturnDetails()
    {

        $collection = Session::get('challan');
        $challanData = Session::get('challan');

        $arrayData = collect($challanData)->pluck('productAmount')
            ->all();

        $total_amount = $this->getTotalAmount($arrayData);
        return view('store.SaleChallanReturn.allProducts', compact('collection', 'total_amount'));
    }
 

  

    public function saveChallan(Request $request)
    {
          $validator = Validator::make($request->all() , [
                'credit_to' => 'required|not_in:0',
                 ]);

        $challanData = Session::get('challan');
        $arrayData = collect($challanData)->pluck('productAmount')->all();
       
        if ($validator->passes())
        {
            $voucherTypeId ='8';
            $debitorVoucherNumber = $this->getSaleChallanVoucherNumber();
            $ledger = Ledger::create([
                'guard_id_from' => auth('store')->user()->guard_id,
                'guard_id_to' => auth('store')->user()->guard_id,
                'voucher_type' => $voucherTypeId,
                'voucher_number' => $debitorVoucherNumber,
                'account_id' =>  Helper::getStoreId(),
                'from' =>auth('store')->user()->id,
                'to' =>$request->credit_to,
                'qty_total' => count(Session::get('challan')) ,
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

         foreach (Session::get('challan') as $id => $product)
            {

                LedgerDetail::create(['ledger_id' => $ledger->id, 'product_stock_id' => $product['productStockId'], 'gin' => $product['gin'], 'product_unit_qty' => $product['exactRatti'], 'product_unit_rate' => $product['exactRattiRate'], 'product_amount' => $product['productAmount'], 'ledger_status' => 1

                ]);

                LedgerDetail::where(['id' => $id])->update(['new_ledger_id' => $ledger->id]);

            }

            Session::forget('challan');
            return response()
                ->json(['success' => true, 'msg' => "Challan Successfully Created.{{$debitorVoucherNumber}}", 'challanNumber' => $debitorVoucherNumber]);
    }

   public function getSaleChallanVoucherNumber(){
   $authUser = UserStore::find(auth('store')->user()->id);

    if($authUser->type == 'org' || $authUser->type == 'lab'){
 
  
       if($ledger = Ledger::where(['account_id' =>$authUser->id,'voucher_type' =>'8'])->latest()->first() ?? false)
       {
          return $ledger->voucher_number+1;

       }else{
          return 1001;
       }
    }else{

        if($ledger = Ledger::where(['account_id' =>$authUser->parentStore->id,'voucher_type' =>'8'])->latest()->first() ?? false)
        {
             return $ledger->voucher_number+1;
        }else{
            return 1001;
        }
    }
   }

    // Not Use Save Challan Method
    public function createIssueChallan(Request $request)
    { 
        $debitor = UserStore::where('id', auth('store')->user()
            ->id)
            ->first();
        $ledger = Ledger::create(['guard_id_from' => auth('store')->user()->guard_id, 'guard_id_to' => auth('store')
            ->user()->guard_id, 'from_voucher_type_id' => $voucherTypeId, 'to_voucher_type_id' => $voucherTypeId, 'from_voucher_number' => $debitorVoucherNumber, 'to_voucher_number' => $creditVoucherNumber, 'account_id_from' => auth('store')->user()->id, 'account_id_to' => $request->manager, 'qty_total' => LedgerDetail::where('temp_number', Session::get('temp_challan_number'))
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

        $debitor->update(['SaleChallanReturn_temp_number' => null]);
        Session::forget('temp_challan_number');
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

    public  function issueChallanAll(){
 
        $userId = Helper::getStoreId();
        $managers = UserStore::where(['org_id'=>$userId,'type'=>'user'])->pluck('id')->toArray();
        $allStoreIds =array_merge($managers,[$userId]);
        $saleChallanReturns  = Ledger::with(['userIssue', 'userReceipt'])->whereIn('from',$allStoreIds)->where('voucher_type','8')->orderBy('id','desc')->get();
        return view('store.SaleChallanReturn.issueChallanAll.all',compact('saleChallanReturns'));
       
       
     }
     
     public function issueChallanDetail($id)
     {   
           $issueChallanDetail = Ledger::with('ledgerDetails')->where('id', $id)->first();
             return view('store.SaleChallanReturn.issueChallanAll.issueChallanDetail', compact('issueChallanDetail'));
     }
     
     
    public function receiveChallanAll(){
        
        $userId = Helper::getStoreId();
        $managers = UserStore::where(['org_id'=>$userId,'type'=>'user'])->pluck('id')->toArray();
        $allStoreIds =array_merge($managers,[$userId]);
        $receiveChallans  = Ledger::with(['userIssue', 'userReceipt'])->whereIn('to',$allStoreIds)->where(['voucher_type'=>'8'])->orderBy('id','desc')->get();

        return view('store.SaleChallanReturn.receiveChallanAll.all',compact('receiveChallans'));   
    
    }
         
          
}

