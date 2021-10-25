<?php

namespace App\Http\Controllers\Store;

use Session;
use App\Helpers\Helper;
use App\Model\Store\Bank;
use App\Model\Store\Ledger;
use App\Helpers\StoreHelper;
use Illuminate\Http\Request;
use App\Model\Guard\UserStore;
use Illuminate\Support\Carbon;
use App\Model\Store\StoreZone; 
use App\Model\Store\LedgerDetail;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use App\Model\Admin\Master\AccountGroup;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use App\Model\Admin\Organization\ZoneCity;
use App\Model\Warehouse\InvoiceDetailGradeProduct; 


class CustomerInvoiceController extends Controller
{

    public function index()
    {
        return view('store.CustomerInvoice.index');
    }

    public function create()
    {
        
        $paymentModes = AccountGroup::whereIn('id',[12,1])->get();   
        return view('store.CustomerInvoice.create',compact('paymentModes'));
    }

    public function findCustomer(Request $request)
    {   
        $customer = UserStore::where('phone',$request->phone)->first() ?? false;
        if($customer){
            return response()->json(['customer'=>$customer]);
        }else{
            return response()->json(['customer'=>false]);
        }
    }

    public function saveCustomer(Request $request)
    { 
         UserStore::create([
             'name' => $request->customer['name'],
             'email' => $request->customer['email'],
             'phone' => $request->customer['phone'],
             'account_group_id' => 22,
             'type' => 'customer',
         ]);
         return true;
    }

    public function saveGins(Request $request)
    {     
        $validator = Validator::make($request->all(),[
            'account' => 'required|not_in:0', 
        ]); 
        $gins = collect($request->gins);
        // $notInStockProductsCustomerInvoice = [];
        // $notExistProductsCustomerInvoice = [];
        foreach ($gins as $gin) {
            $response = $this->saveGin($gin); 
            // if ($response == 'Not In Stock') {
            //     $notInStockProductsCustomerInvoice[] = ['gin' => $gin];
            // }
            // if ($response == 'Not Exist') {
            //     $notExistProductsCustomerInvoice[] = ['gin' => $gin];
            // }
        }; 
        // Session::put('notExistProductsCustomerInvoice', $notExistProductsCustomerInvoice);
        // Session::put('notInStockProductsCustomerInvoice', $notInStockProductsCustomerInvoice);
    } 

    public function getAllDetails()
    {  
        $countCarat = collect(Session::get('CustomerInvoice'))->pluck('mrpAmount')->toArray();
        $countCarat = collect($countCarat);
        $totalAmount = $countCarat->reduce(function ($carry, $item) {
            return $carry + $item;
         });  

        return response()->json([ 
            'validProducts'=> Session::get('CustomerInvoice'), 
            'totalAmount'=> $totalAmount, 
        ]);
    }

    
    public function saveGin($gin)
    {   
        $gin = $gin['gin'];
        $getGin = $this->isProductInStock($gin);  
        // if ($getGin == "Invalid") {
        //     return 'Not Exist';
        // }   
        // if ($getGin == false) { 
        //     return 'Not In Stock';
        // }
        if($getGin){
        if($getGin->gin == $gin){
            $productStock = InvoiceDetailGradeProduct::query()
            ->with('productGrade:id,alias', 'product:id,name', 'ratti:id,rati_standard,rati_big')
            ->select('id', 'gin', 'product_id', 'product_category_id', 'grade_id', 'ratti_id', 'weight', 'in_stock')
            ->where(['gin' => $getGin->gin])
            ->first() ?? false;
            $CustomerInvoiceSession = Session::get('CustomerInvoice');
            if (!$CustomerInvoiceSession) {
                return $this->setSessionEmptty($productStock);
            }
            // if (isset($CustomerInvoiceSession[$productStock->id])) {
            //     return 'Product Already Added';
            // }
            $productRate = StoreHelper::getProductGradeRattiRattiRateMrpAmount($productStock);
            $CustomerInvoiceSession[$productStock->id] = [
                'id' => $productStock->id,
                'gin' => $productStock->gin,
                'product' => $productStock->product->name,
                'grade' => $productStock->productGrade->alias ?? '',
                'ratti' => $productStock->ratti->rati_standard ?? "",
                'productStockRatti' => $productRate['productStockRatti'],
                'rattiRate' => $productRate['rattiRate'],
                'mrpAmount' => $productRate['mrpAmount'],
                'productStockId' => $productRate['productStockId'],

            ];
            Session::put('CustomerInvoice', $CustomerInvoiceSession); 
        }
        
            
    }
    }

    public function isProductInStock($gin)
    {  
        if(!InvoiceDetailGradeProduct::where('gin',$gin)->first() ?? false){
            return false;
        } 

        $authUser = UserStore::find(auth('store')->user()->id); 
        if($authUser->type == 'org' || $authUser->type == 'lab')
        {
            if( $ledgerStock = LedgerDetail::with('ledger')->where(['gin' => $gin, 'new_ledger_id' => null])
                      ->whereHas('ledger', function ($q) use ($authUser){
                        $q->where(['account_id' => $authUser->id, 'voucher_type'=>'1']);
                       })->first() ?? false ){
              return $ledgerStock;
            }
            elseif( $ledgerStock = LedgerDetail::with('ledger')
                                 ->where(['gin' => $gin, 'new_ledger_id' => null])
                                 ->whereHas('ledger', function ($q) use ($authUser) {
                                    $q->where(['to' =>$authUser->id, 'voucher_type'=>'2']);
                                 })->first() ?? false){
                 return $ledgerStock;
            }else{
                return false;
            } 
        }else{
            $ledgerStock = LedgerDetail::with('ledger')
                         ->where(['gin' => $gin, 'new_ledger_id' => null])
                         ->whereHas('ledger', function ($q) use ($authUser) {
                            $q->where(['to' =>$authUser->id, 'voucher_type'=>'2']);
                             })->first() ?? false;
            return $ledgerStock;
        }
     }

    public function setSessionEmptty($productStock)
    {
        $productRate = StoreHelper::getProductGradeRattiRattiRateMrpAmount($productStock);

        $CustomerInvoiceSession = [
            $productStock->id => [
                'id' => $productStock->id,
                'gin' => $productStock->gin,
                'product' => $productStock->product->name,
                'grade' => $productStock->productGrade->alias ?? '',
                'ratti' => $productStock->ratti->rati_standard ?? "",
                'productStockRatti' => $productRate['productStockRatti'],
                'rattiRate' => $productRate['rattiRate'],
                'mrpAmount' => $productRate['mrpAmount'],
                'productStockId' => $productRate['productStockId'],

            ]
        ];
        Session::put('CustomerInvoice', $CustomerInvoiceSession);
        return 'Success';
    }

    //Remove Product From Session
    public function delete($id)
    {
        $challan = Session::get('CustomerInvoice');
        if (isset($challan[$id]))
        {
            unset($challan[$id]);
            Session::put('CustomerInvoice', $challan);
        }
        return response()->json(['success' => true]);
    }
    

    public function getPaymentAccounts($paymentModeId)
    {   
        if($paymentModeId == 1){
            $paymentModeAccounts = UserStore::whereId(auth()->user()->id)->get();
        }else{
            $paymentModeAccounts = Bank::where(['org_id' => StoreHelper::getStoreId(),'account_group_id' => $paymentModeId])->get();
        }  
        return $paymentModeAccounts;
    } 
    
    public function paymentSave(Request $request)
    {     
        $from =StoreHelper::getUserStoreById($request->customerId);
        $to =StoreHelper::getUserStoreById($request->customer['toAccount']); 
        $voucherTypeId = '9';

        $ledger = Ledger::create([
                'guard_id_from' => auth('store')->user()->guard_id,
                'guard_id_to' => auth('store')->user()->guard_id, 
                'voucher_type' =>  $voucherTypeId, 
                'voucher_number' => StoreHelper::getVoucherNumber($to->id,$voucherTypeId), 
                'account_id' =>  StoreHelper::getUserStoreId($to->id),
                'from' => $from->id,
                'to' =>  $to->id, 
                'total_amount' => $request->customer['amount'],
                // 'comment' => $request->comment, 
                'status' => '1',
                // 'reference_number' => $request->reference_number, 
                'created_by' => auth('store')->user()->id
        ]);
        
        $msg = 'Payment Success Voucher :'.$ledger->voucher_number .'And Amount'.$ledger->total_amount;
        return response()->json(['msg'=> $msg]);
        // $msg = 'Your Payment Issued Successfully. Transaction No. '. $ledger->voucher_number;
        // return response()->json(['success' => true,'msg' => $msg]);
    }
 
    public function placeOrder(Request $request)
    { 
        $CustomerInvoice = Session::get('CustomerInvoice'); 
        $to =StoreHelper::getUserStoreById($request->customerId);  

        $ledger = Ledger::create([
            'guard_id_from' => auth('store')->user()->guard_id,
            'guard_id_to' => auth('store')->user()->guard_id,
            'voucher_type' => '3',
            'voucher_number' => StoreHelper::getVoucherNumber(auth('store')->user()->id,3),
            'account_id' =>  StoreHelper::getStoreId(),
            'from' => auth('store')->user()->id,
            'to' => $to->id,
            // 'comment' => $request->comment ?? "",
            'status' => '1', 
        ]); 
          
        foreach (Session::get('CustomerInvoice') as $id => $product) {  
            LedgerDetail::create([
                'ledger_id' => $ledger->id,
                'product_stock_id' => $product['id'],
                'gin' => $product['gin'],
                'name' => $itemName ?? "",
                'weight' => $item->weight ?? "0",
                'product_unit_qty' => $product['productStockRatti'],
                'product_unit_rate' => $product['rattiRate'],
                'ledger_status' => 1,
                'product_amount' => $product['mrpAmount'],  
                'total_amount' => $product['mrpAmount'],
            ]);  
            LedgerDetail::where('id', LedgerDetail::where(['gin'=>$product['gin'],'new_ledger_id'=>null])->first()->id)->update(['new_ledger_id' => $ledger->id]);
        }

        $ledgerId = $ledger->id;
        
        $productsAmount = $ledger->countProductAmount($ledgerId); 
        $totalAmount = $ledger->countTotalAmount($ledgerId);
        $totalQty = $ledger->countTotalQty($ledgerId);
        
        Ledger::where('id',$ledgerId) ->update([
            'products_amount' => $productsAmount, 
            'total_amount' => $totalAmount,
            'qty_total' => $totalQty,
        ]);

        Session::forget('CustomerInvoice');  
        $msg = 'Order Placed Voucher :'.$ledger->voucher_number;
        return response()->json(['msg'=> $msg]);
    }

 
}
