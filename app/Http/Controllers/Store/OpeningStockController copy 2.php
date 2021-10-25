<?php
namespace App\Http\Controllers\Store;
use Session;
use Validator;
use App\Helpers\Helper;
use App\Model\Store\Ledger;
use Illuminate\Http\Request;
use App\Model\Guard\UserStore;
use App\Model\Store\LedgerDetail;
use App\Model\Admin\Master\Voucher;
use App\Http\Controllers\Controller;
use App\Model\Store\LedgerDetailTemp;
use App\Model\Warehouse\InvoiceDetailGradeProduct;

class OpeningStockController extends Controller
{

    public function index()
    {

        return view('store.openingStock.index');

    }

    public function create()
    {

        //Session::forget('openingStock');
        return view('store.openingStock.create');

    }

    public function saveGin(Request $request)
    {

        $validator = Validator::make($request->all() , 
        ['gin' => 'required']);
        if ($validator->passes())
        {   
         
                $productStock = InvoiceDetailGradeProduct::select('id','gin','in_stock')->where(['gin'=>$request->gin,'in_stock'=>1])->first() ?? false;
               

                    
                if($productStock){
                    if(LedgerDetailTemp::where(['product_stock_id'=>$productStock->id,'user_id'=>auth('store')->user()->id])->exists()){
                        return response()->json(['success' => false, 'msg' => "Already Added"]);
                    } 

                   LedgerDetailTemp::create([
                       'user_id' => auth('store')->user()->id,
                       'store_id' => Helper::getStoreId(),
                       'voucher_type_id' => 1,
                       'product_stock_id' => $productStock->id,
                   ]);
                   return response()->json(['success' => true, 'msg' => "Product Inserted Success"]);
                }else{
                    return response()->json(['success' => false, 'msg' => "Gin Out Stock"]);
                }
            

            // $productStock = InvoiceDetailGradeProduct::with('productGrade:id,grade', 'product:id,name', 'ratti:id,rati_standard,rati_big')->select('id', 'gin', 'product_id', 'product_category_id', 'grade_id', 'ratti_id', 'weight', 'in_stock')
            //     ->where(['gin' => $request->gin, 'in_stock' => 1])
            //     ->first();
            // if (InvoiceDetailGradeProduct::where(['gin' => $request->gin, 'in_stock' => 0])
            //     ->exists())
            // {
            //     return response()
            //         ->json(['success' => false, 'msg' => "GIn Out Stock"]);
            // }

            // elseif (empty($productStock))
            // {
            //     return response()->json(['success' => false, 'msg' => "GIN Does Not Exists"]);
            // }
            // else
            // {
            //     $openingStockSession = Session::get('openingStock');
            //     if (!$openingStockSession)
            //     {
            //         return $this->setSessionEmptty($productStock);
            //     }
            //     elseif (isset($openingStockSession[$productStock
            //         ->id]))
            //     {

            //         return response()
            //             ->json(['exist' => true, 'msg' => 'Product Already Added']);
            //     }

            //     $productRate = $this->getProductGradeRatti($productStock);
            //     $openingStockSession[$productStock->id] = ['gin' => $productStock->gin, 'product' => $productStock
            //         ->product->name, 'grade' => $productStock
            //         ->productGrade->grade??'', 'ratti' => $productStock
            //         ->ratti->rati_standard??"", 'exactRatti' => $productRate['excactRatti'], 'exactRate' => $productRate['exactRattiRate'], 'exactAmount' => $productRate['amount']];
            //     Session::put('openingStock', $openingStockSession);
            //     $this->productOutStock($productStock);

                // return response()->json(['success' => true, 'msg' => "Product Inserted Success"]);
            // }
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

    public function saveOpeningStock(Request $request)
    {

        $validator = Validator::make($request->all() , ['credit_to' => 'required|not_in:0',

        ]);
        if ($validator->passes())
        {   

            // $openingStock = Session::get('openingStock');

            // $amount = collect($openingStock)->pluck('exactAmount')
            //     ->all();

            // $total_amount = $this->getTotalAmount($amount);
 
            // $creditVoucherNumber = Helper::getCreditVoucherNumber(auth('store')->user()->id, $voucherType);
            $ledger = Ledger::create([
                'guard_id_from' => 5,
                'guard_id_to' => 5, 
                'voucher_type' => '1',
                'voucher_number' => $this->getVoucherNumber(),
                'account_id' => $request->credit_to,
                // 'qty_total' => count(Session::get('openingStock')) ,
                //  'amount_total' => $total_amount, 
                 'comment' => $request->comment, 'status' => '1'
            ]);
            $ledgerDetailTemps = LedgerDetailTemp::where([
                'user_id' => auth('store')->user()->id,
                'voucher_type_id' => 1,
                'store_id' => Helper::getStoreId(),

            ])->get();

            foreach($ledgerDetailTemps as $detail){
                $productStock = InvoiceDetailGradeProduct::find($detail->product_stock_id);
                $productRate = $this->getProductGradeRatti($productStock);
                 LedgerDetail::create([
                    'ledger_id' => $ledger->id,
                    'product_stock_id' => $detail->product_stock_id,
                    'gin' => $detail->productStock->gin,
                    'product_unit_qty' => $productRate['excactRatti'],
                    'product_unit_rate' => $productRate['exactRattiRate'], 
                    'product_amount' => $productRate['amount'], 
                    'ledger_status' => 1  
                ]);
            }

            Ledger::where('id',$ledger->id)->update([
                'qty_total' => LedgerDetail::where('ledger_id',$ledger->id)->count(),
                'amount_total' => 'Pending',
            ]);
            

            // foreach (Session::get('openingStock') as $id => $product)
            // {

            //     LedgerDetail::create([
                // 'ledger_id' => $ledger->id, 
                // 'product_stock_id' => $id,
                //  'gin' => $product['gin'], 
                //  'product_unit_qty' => $product['exactRatti'],
                //   'product_unit_rate' => $product['exactRate'], 
                //   'product_amount' => $product['exactAmount'], 
                //   'ledger_status' => 1

            //     ]);

            // }

            // Session::forget('openingStock');
            return response()->json(['success' => true, 'msg' => "Opening Stock Successfully Created.{{$ledger->voucher_number}}", 'voucherNumber' => $ledger->voucher_number]);

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

    public function getVoucherNumber(){

        $authUser = UserStore::find(auth('store')->user()->id);
         
            if($authUser->type == 'org' || $authUser->type == 'lab'){
       
                if($ledger = Ledger::where('account_id' ,$authUser->id)->where('voucher_type','1')->latest()->first() ?? false)
                {
                   return $ledger->voucher_number+1;
                }else{
                   return 1001;
                }
             }else{
                 if($ledger = Ledger::where('account_id' ,$authUser->parentStore->id)->where('voucher_type','1')->latest()->first() ?? false)
                 {
                      return $ledger->voucher_number+1;
                 }else{
                     return 1001;
                 }
             }
      
    }

    public function all()
    { 
        $ledgerDetailTemps = LedgerDetailTemp::where([
            'user_id' => auth('store')->user()->id,
            'voucher_type_id' => 1,
            'store_id' => Helper::getStoreId(),

        ])->get();
        // dd($ledgerDetailTemps);
        // $products = InvoiceDetailGradeProduct::whereIn('id',$productStockIds)->get();
        return view('store.openingStock.all', compact('ledgerDetailTemps'));

    }

    public function allVouchers()
    {

        $vouchers = Ledger::Select('id', 'guard_id_to','voucher_type', 'voucher_number', 'account_id', 'amount_total', 'qty_total', 'comment', 'created_at')->has('ledgerDetails')
            ->with("ledgerDetails:id,ledger_id,product_stock_id,product_unit_qty,product_unit_rate,product_amount")
            ->where(['account_id'=> auth('store')->user()->id,'voucher_type'=>'1'])->orderBy('id','desc')->get();
        return view('store.openingStock.allVoucher', compact('vouchers'));
    }

    public function totalStockDetail($id)
    {
        
        $voucherDetail = LedgerDetail::select('id', 'ledger_id', 'gin', 'product_stock_id', 'product_unit_qty', 'product_unit_rate', 'product_amount')->has('ledger')
            ->with(['ledger:id,voucher_number', 'productStock:id,gin,product_id,grade_id,ratti_id'])
            ->where(['ledger_id' => $id])->get();
        return view('store.openingStock.totalStockDetail', compact('voucherDetail'));

    }


    public function leftStockDetail($id)
    {
        
        $voucherDetail = LedgerDetail::select('id', 'ledger_id', 'gin', 'product_stock_id', 'product_unit_qty', 'product_unit_rate', 'product_amount')->has('ledger')
            ->with(['ledger:id,voucher_number', 'productStock:id,gin,product_id,grade_id,ratti_id'])
            ->where(['ledger_id' => $id, 'new_ledger_id' => null])->get();
        return view('store.openingStock.leftStockDetail', compact('voucherDetail'));

    }

    public function delete($id)
    {
         LedgerDetailTemp::where('id',$id)->delete();
        // $openingStock = Session::get('openingStock');
        // if (isset($openingStock[$id]))
        // {
        //     unset($openingStock[$id]);

        //     Session::put('openingStock', $openingStock);
        //     $this->productInStock($id);

        // }
        return response()->json(['success' => true]);

    }

    public function getProductGradeRatti($productStock)
    {

        $productRateProfile = Helper::getRateProfile($productStock->product_id, $productStock->grade_id);
        $productRate = Helper::getCalculateWeight($productStock->weight, $productRateProfile);

        return $productRate;
    }

    // public function setSessionEmptty($productStock)
    // {

    //     $productRate = $this->getProductGradeRatti($productStock);

    //     $openingStockSession = [$productStock->id => ['gin' => $productStock->gin, 'product' => $productStock
    //         ->product->name, 'grade' => $productStock
    //         ->productGrade->grade??'', 'ratti' => $productStock
    //         ->ratti->rati_standard??"", 'exactRatti' => $productRate['excactRatti'], 'exactRate' => $productRate['exactRattiRate'], 'exactAmount' => $productRate['amount']]];
    //     Session::put('openingStock', $openingStockSession);
    //     $this->productOutStock($productStock);
    //     return response()->json(['success' => true, 'msg' => "Product Inserted Success"]);

    // }

    public function productOutStock($productStock)
    {
        return InvoiceDetailGradeProduct::find($productStock->id)
            ->update(['in_stock' => 0]);
    }

    public function productInStock($id)
    {
        return InvoiceDetailGradeProduct::find($id)->update(['in_stock' => 1]);
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

    // public function setSessionNotEmpty($productStock){
    //     $productRate = $this->getProductGradeRatti($productStock);
    //    $openingStockSession[$productStock->id] = [
    //                            'gin' => $productStock->gin,
    //                            'product' => $productStock->product->name,
    //                            'grade' => $productStock->productGrade->grade ?? '',
    //                            'ratti' => $productStock->ratti->rati_standard ?? "",
    //                             'exactRatti' => $productRate['excactRatti'],
    //                            'exactRate' => $productRate['exactRatiRate']
    //                ];
    

    //                  Session::put('openingStock',$openingStockSession);
    //                return response()->json(['success'=>true,'msg'=> "Product Inserted Success"]);
    

    // }
    

    
}

