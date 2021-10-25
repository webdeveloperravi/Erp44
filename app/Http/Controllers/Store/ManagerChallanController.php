<?php

namespace App\Http\Controllers\Store;

use App\Helpers\Helper;
use App\Model\Store\Ledger;
use Illuminate\Http\Request;
use App\Model\Guard\UserStore;
use App\Model\Store\DeliveryMode;
use App\Model\Store\LedgerDetail;
use App\Model\Admin\Master\Voucher;
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Session;
use App\Model\Warehouse\InvoiceDetailGradeProduct;
use App\Model\Admin\Master\ProductRateProfileWeightRange;
use Validator;
class ManagerChallanController extends Controller
{
    
    public function index(){
     return view('store.manager_challan.index');
    }

         
    public function create()
    {

        // dd(auth('store')->user()->parentStore->id);
        //Session::forget('managerCreateChallan');
        $accounts = UserStore::select('id', 'name', 'company_name', 'type')->where('type', 'org')
            ->orWhere('type', 'lab')
            ->get();
        return view('store.manager_challan.create', compact('accounts'));
    }

    public function getManagers($accountId)
    {
        $managers = UserStore::select('id', 'name')->where(['org_id' => $accountId, 'type' => 'user'])->get();

        return view('store.manager_challan.managerList', compact('managers'));
    }

    public function saveGin(Request $request){

      
        $validator = Validator::make($request->all() , ['gin' => 'required', 'account' => 'required|not_in:0', 'manager' => 'required|not_in:0',

        ]);

        if ($validator->passes())
        {
              
               $productStockGin = LedgerDetail::where(['gin'=>$request->gin,'new_ledger_id'=>null])->whereHas('ledger',function($q)  {
                $q->where('account_id_to',auth('store')->user()->id);
           })->first();


        if(empty($productStockGin))
        {
          return response()->json(['success'=>false,'msg'=> "GIN Does Not Exists"]);   
        }
        else
        {
                
            $managerCreateChallan = Session::get('managerCreateChallan');

                if (!$managerCreateChallan)
               {
                    
                    $managerCreateChallan = [
                       
                       $productStockGin->id => [
                      'gin' => $productStockGin->gin,
                      'productStockId' => $productStockGin->product_stock_id, 
                      'product' => $productStockGin ->productStock->product->name, 
                      'grade' => $productStockGin->productStock->productGrade->grade, 
                      'ratti' => $productStockGin->productStock->ratti->rati_standard,
                      'exactRatti' => $productStockGin->product_unit_qty, 
                      'exactRattiRate' => $productStockGin->product_unit_rate, 
                      'productAmount' => $productStockGin->product_amount
                    ]];
                     
                    Session::put('managerCreateChallan', $managerCreateChallan);
                    // Session::put('orderId',$request->temp_number);
                    return response()->json(['success' => true, 'msg' => "Product Inserted Success"]);

                }
                elseif (isset($managerCreateChallan[$productStockGin
                    ->id]))
                {

                    return response()
                        ->json(['success' => false, 'msg' => 'Product Already Added']);
                }
                $managerCreateChallan[$productStockGin->id] = [

                      'gin' => $productStockGin->gin,
                      'productStockId' => $productStockGin->product_stock_id, 
                      'product' => $productStockGin ->productStock->product->name, 
                      'grade' => $productStockGin->productStock->productGrade->grade, 
                      'ratti' => $productStockGin->productStock->ratti->rati_standard,
                      'exactRatti' => $productStockGin->product_unit_qty, 
                      'exactRattiRate' => $productStockGin->product_unit_rate, 
                      'productAmount' => $productStockGin->product_amount

                ];
                Session::put('managerCreateChallan', $managerCreateChallan);
                        // $storePurchaseOrderDetail->update([
                        // 'insert_qty' => $storePurchaseOrderDetail->insert_qty+1,
                        // ]);
                    return response()->json(['success'=>true,'msg'=> "Product Inserted Success"]);
              //   }else{
              //       return response()->json(['success'=>false,'msg'=> "Qty Limit Exceed"]);
              //   }

              //      }
              //      else{
              //   return response()->json(['success'=>false,'msg'=> " Product Requirement Not Exist "]);
              //     }
              // }
       }
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

      }

      public function sessionData()
    {

        $collection = Session::get('managerCreateChallan');
        $challanData = Session::get('managerCreateChallan');

        $arrayData = collect($challanData)->pluck('productAmount')
            ->all();

        $total_amount = $this->getTotalAmount($arrayData);
        return view('store.manager_challan.sessionData', compact('total_amount'));
    }

     // remove Product From Session
    public function sessionDataDelete($id)
    {
        $challan = Session::get('managerCreateChallan');
        if (isset($challan[$id]))
        {
            unset($challan[$id]);
            Session::put('managerCreateChallan', $challan);
        }
        return response()->json(['success' => true]);
    }


    public function saveChallan(Request $request){

        $validator = Validator::make($request->all() , ['manager' => 'required|not_in:0',

        ]);

        $challanData = Session::get('managerCreateChallan');
        $arrayData = collect($challanData)->pluck('productAmount')
            ->all();
        if ($validator->passes())
        {

            $voucherTypeId = Voucher::where('name', 'Challan')->first()->id;
            $debitorVoucherNumber = Helper::getDebitVoucherNumber(auth('store')->user()->parentStore->id, $voucherTypeId);
            $ledger = Ledger::create(['guard_id_from' => auth('store')->user()->guard_id, 'guard_id_to' => auth('store')
                ->user()->guard_id, 'from_voucher_type_id' => $voucherTypeId, 'to_voucher_type_id' => $voucherTypeId, 'from_voucher_number' => $debitorVoucherNumber, 'account_id_from' => auth('store')->user()->id, 'account_id_to' => $request->manager, 'qty_total' => count(Session::get('managerCreateChallan')) , 'amount_total' => $this->getTotalAmount($arrayData) , 'comment' => $request->comment, 'status' => '1', ]);

            foreach (Session::get('managerCreateChallan') as $id => $product)
            {

                LedgerDetail::create(['ledger_id' => $ledger->id, 'product_stock_id' => $product['productStockId'], 'gin' => $product['gin'], 'product_unit_qty' => $product['exactRatti'], 'product_unit_rate' => $product['exactRattiRate'], 'product_amount' => $product['productAmount'], 'ledger_status' => 1

                ]);

                LedgerDetail::where(['id' => $id])->update(['new_ledger_id' => $ledger->id]);

            }

            Session::forget('managerCreateChallan');
            return response()
                ->json(['success' => true, 'msg' => "Challan Successfully Created.{{$debitorVoucherNumber}}", 'challanNumber' => $debitorVoucherNumber]);

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



    






  
        // Receipt Challans 
        public function receiptChallans(){

            $receiveChallans = Ledger::with(['userIssue', 'userReceipt'])->where('to', auth('store')->user()->id)->orderBy('id','desc')->get();
            return view('store.manager_challan.receiveChallan', compact('receiveChallans'));
           }
        
           // Receipt Challan Detail 
        
           public function receiptChallanDetail($id)
           {
        
                $receiveChallan = Ledger::with('ledgerDetails')->where(['to'=>auth('store')->user()->id,'id'=>$id])->first();
                return view('store.manager_challan.receiveChallanDetail',compact('receiveChallan'));
        
           }
        
        

   // Issue Challans
     public function issueChallans()
    {
     $issueChallans = Ledger::with(['userIssue', 'userReceipt','ledgerDetails'])->where('account_id_from', auth('store')->user()->id)->orderBy('id','desc')->get();
          return view('store.manager_challan.issueChallan', compact('issueChallans'));
    }

  // Issue Challan Detail

    public function issueChallanDetail($id){
     
        $issueChallanDetail = Ledger::with('ledgerDetails')->where(['account_id_from'=>auth('store')->user()->id,'id'=>$id])->first();
         return view('store.manager_challan.issueChallanDetail',compact('issueChallanDetail'));   

    }






    public function allChallans(){
  
          $challans = Ledger::where('credit_to',auth('store')->user()->id)->get();
          return view('store.manager_challan.all',compact('challans'));
    }

    public function view($id){
        
        $challan = Ledger::find($id);
        return view('store.manager_challan.view',compact('challan'));
    }

    public function prepareDelivery($id){

        $challan = Ledger::find($id);
        $deliveryModes = DeliveryMode::all();
        return view('store.manager_challan.prepareDelivery',compact('challan','deliveryModes'));
    }

    public function getDeliveryManager($id){
   
        if($id==1){
               $users = UserStore::where('type','user')->get(); 
               return view('store.manager_challan.delivery_users',compact('users'));
        }
    }

    public function deliverNow(Request $request){
        
            // $tempNumber = Session::get('sale_order_temp_number') ?? "";
            $debitorVoucherNumber = Helper::generateVoucherNumber(auth('store')->user()->id);
            $creditorVoucherNumber = Helper::generateVoucherNumber($request->manager_id);
            $voucherTypeId = Voucher::where('name','Challan')->first()->id;
            $ledgerDetails = LedgerDetail::whereIn('id',$request->products)->get();
            // dd($ledgerDetails);
            $debitor = UserStore::where('id',auth('store')->user()->id)->first();
            
            $ledger = Ledger::create([
                'from_voucher_type_id' => $voucherTypeId,
                'to_voucher_type_id' =>$voucherTypeId,
                'from_voucher_number' => $debitorVoucherNumber,
                'to_voucher_number' => $creditorVoucherNumber,
                'debit_by' => auth('store')->user()->id, 
                'credit_to' => $request->manager_id,
                'qty' => LedgerDetail::whereIn('id',$request->products)->count(),
                'status' => '1'
            ]);
            // dd($ledger);
            foreach($ledgerDetails as $detail){
                $detail->update(['new_ledger_id'=> $ledger->id]);
                ledgerDetail::Create([
                    'ledger_id' => $ledger->id,
                    'product_stock_id' => $detail->product_stock_id,
                    'amount' => $this->getProductPrice($detail->product_stock_id)  
                ]);
            }

            $updateDebitorVoucherNumber = UserStore::where('id',auth('store')->user()->id)
                                            ->first()
                                            ->update(['voucher_number' => $debitorVoucherNumber ]);

            $updateCreditorVoucherNumber = UserStore::where('id',$request->manager_id)
                                            ->first()
                                            ->update(['voucher_number' => $creditorVoucherNumber ]);

            // $debitor->update(['sale_order_temp_number'=> null]);                               

            return view('store.sale_order.success');

        
    }
    public function getProductPrice($productId){
    
        $product = InvoiceDetailGradeProduct::with('rateProfile')->where('id',$productId)->first();
        
       return $weightRange = ProductRateProfileWeightRange::where('rate_profile_id',$product->rateProfile->id)->where('from','<',$product->weight)->where('to','>=',$product->weight)->first()->unit->ratti_rate;
     
      }
    
 



public function createChallan($creditTo){
    
    $tempNumber = Session::get('sale_order_temp_number') ?? "";
    $debitorVoucherNumber = Helper::generateVoucherNumber(auth('store')->user()->id);
    $creditorVoucherNumber = Helper::generateVoucherNumber($creditTo);
    $voucherTypeId = Voucher::where('name','Challan')->first()->id;
    $ledgerDetails = LedgerDetail::where('temp_number',$tempNumber)->get();
    $debitor = UserStore::where('id',auth('store')->user()->id)->first();
    
    $ledger = Ledger::create([
        'from_voucher_type_id' => $voucherTypeId,
        'to_voucher_type_id' =>$voucherTypeId,
        'from_voucher_number' => $debitorVoucherNumber,
        'to_voucher_number' => $creditorVoucherNumber,
        'debit_by' => auth('store')->user()->id, 
        'credit_to' => $creditTo,
        'qty' => LedgerDetail::where('temp_number',$tempNumber)->count(),
        'status' => '1'
    ]);

    foreach($ledgerDetails as $detail){
        $detail->update(['ledger_id'=> $ledger->id,'temp_number' => null]);
    }

    $updateDebitorVoucherNumber = UserStore::where('id',auth('store')->user()->id)
                                    ->first()
                                    ->update(['voucher_number' => $debitorVoucherNumber ]);

    $updateCreditorVoucherNumber = UserStore::where('id',$creditTo)
                                    ->first()
                                    ->update(['voucher_number' => $creditorVoucherNumber ]);

    $debitor->update(['sale_order_temp_number'=> null]);                               

    return view('store.sale_order.success');
     
}







}
