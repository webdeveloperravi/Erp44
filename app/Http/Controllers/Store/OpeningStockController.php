<?php

namespace App\Http\Controllers\Store;
use Session;
use Validator;
use Inertia\Inertia;
use App\Helpers\Helper;
use Barryvdh\DomPDF\PDF;
use App\Model\Store\Ledger;
use App\Helpers\StoreHelper;
use Illuminate\Http\Request;
use App\Model\Guard\UserStore;
use App\Model\Store\LedgerDetail;
use Illuminate\Support\Facades\DB;
use App\Model\Admin\Master\Voucher;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\Builder;
use App\Model\Warehouse\InvoiceDetailGradeProduct;

class OpeningStockController extends Controller
{

    public function index()
    {     
        $ledgers = Ledger::Select('id', 'guard_id_to','voucher_type', 'voucher_number', 'account_id', 'total_amount', 'qty_total', 'comment', 'created_at') 
            ->with("ledgerDetails:id,ledger_id,product_stock_id,product_unit_qty,product_unit_rate,product_amount")
            ->withCount(['ledgerDetails as left_qty' => function(Builder $query){
                $query->where('new_ledger_id',null);
            }])
            ->withCount(['ledgerDetails as left_amount' => function(Builder $query){ 
                $query->select(DB::raw("SUM(total_amount)"))->where('new_ledger_id',null);
            }]) 
            ->where(['account_id'=> auth('store')->user()->id,'voucher_type'=>'1'])->orderBy('id','desc')->paginate(50);  
        return view('store.openingStock.index',compact('ledgers'));
    }

    public function find($voucherNumber)
    {
        $ledger = Ledger::Select('id', 'guard_id_to','voucher_type', 'voucher_number', 'account_id', 'total_amount', 'qty_total', 'comment', 'created_at') 
            ->with("ledgerDetails:id,ledger_id,product_stock_id,product_unit_qty,product_unit_rate,product_amount")
            ->withCount(['ledgerDetails as left_qty' => function(Builder $query){
                $query->where('new_ledger_id',null);
            }])
            ->withCount(['ledgerDetails as left_amount' => function(Builder $query){ 
                $query->select(DB::raw("SUM(total_amount)"))->where('new_ledger_id',null);
            }]) 
            ->where(['account_id'=> auth('store')->user()->id,'voucher_type'=>'1'])
            ->where('voucher_number',$voucherNumber)->first()
            ;  
            // dd($ledger);
        return view('store.openingStock.findView',compact('ledger'));
    }
    
    public function view($id)
    {
        $ledger = Ledger::with(['ledgerDetails','ledgerDetails.productStock','ledgerDetails.productStock.product','ledgerDetails.productStock.productGrade','ledgerDetails.productStock.ratti','mediaImages'])
                  ->where(['id' => $id,'account_id' =>auth('store')->user()->id ])->first() ?? abort(404);
        return view('store.openingStock.view', compact('ledger'));
    }
    
    public function printReport($ledgerId,$type){
        
        $ledger = Ledger::find($ledgerId); 
        $ledgerDetails = LedgerDetail::select('id', 'ledger_id', 'gin', 'product_stock_id', 'product_unit_qty', 'product_unit_rate', 'product_amount')->has('ledger')
            ->with(['ledger:id,voucher_number', 'productStock'])
            ->where(['ledger_id' => $ledgerId]) 
            ->get();
        return view('store.openingStock.printReport',compact('ledger','ledgerDetails','type'));
    }
    
    public function detailsPrint($ledgerId)
    {
        $ledger = Ledger::find($ledgerId); 
        $ledgerDetails = LedgerDetail::select('id', 'ledger_id', 'gin', 'product_stock_id', 'product_unit_qty', 'product_unit_rate', 'product_amount')->has('ledger')
            ->with(['ledger:id,voucher_number', 'productStock'])
            ->where(['ledger_id' => $ledgerId])
            ->orderBy('product_unit_qty')
            ->get();
        return view('store.openingStock.detailsPrint',compact('ledger','ledgerDetails'));
    }

    public function create()
    {   
        $accountName = UserStore::find(StoreHelper::getStoreId())->company_name ?? ""; 
        return view('store.openingStock.create',compact('accountName'));
    }

    public function saveGins(Request $request)
    {   
       $gins = collect($request->gins);
       $outOfStockProducts = [];
       $notExistProducts = [];
       foreach($gins as $gin){
        $response = $this->saveGin($gin['gin']);
        if($response == 'Out of Stock'){
            $outOfStockProducts[] = ['gin'=>$gin['gin']];
         }
         if($response == 'Not Exist'){
             
         $notExistProducts[] = ['gin'=>$gin['gin']];
        }
       };  
       $notExistProducts = collect($notExistProducts)->pluck('gin')->toArray();
       $outOfStockProducts = collect($outOfStockProducts)->pluck('gin')->toArray();
       Session::put('notExistProducts',$notExistProducts);
       Session::put('outOfStockProducts',$outOfStockProducts);

       return response()->json(['outOfStockProducts' =>$outOfStockProducts,'notExistProducts'=> $notExistProducts]);
    }

    public function getAllDetails()
    {
      
        return response()->json([
            'outOfStockProducts' => Session::get('outOfStockProducts'),
            'notExistProducts'=> Session::get('notExistProducts'),
            'validProducts'=> Session::get('openingStock'),
            'notInStockProductsCount'=> Session::has('outOfStockProducts') ?  count(Session::get('outOfStockProducts')) : 0,
            'notExistProductsCount'=> Session::has('notExistProducts') ?  count(Session::get('notExistProducts')) : 0,
            'validProductsCount'=> Session::has('openingStock') ?  count(Session::get('openingStock')) : 0,
        ]);
    }
    
    public function delete($id)
    {
        $openingStock = Session::get('openingStock');
        if (isset($openingStock[$id]))
        {
            unset($openingStock[$id]);
            Session::put('openingStock', $openingStock); 
        }
        return response()->json(['success' => true]);
    }

    public function saveOpeningStock(Request $request)
    {    
        if(!Session::has('openingStock')){
            return response()->json(['validProducts'=>true]);
        }elseif(count(Session::get('openingStock')) == 0){
            return response()->json(['validProducts'=>true]);
        }
           
        $openingStock = Session::get('openingStock');
        $amount = collect($openingStock)->pluck('mrpAmount')->all();
        $total_amount = StoreHelper::countTotal($amount);
        try{
            DB::beginTransaction(); 
       
        $ledger = Ledger::create([
            'guard_id_from' => auth('store')->user()->guard_id,
            'guard_id_to' => auth('store')->user()->guard_id, 
            'voucher_type' => '1',
            'voucher_number' => StoreHelper::getVoucherNumber(auth('store')->user()->id,1),
            'account_id' => StoreHelper::getStoreId(),  
            'comment' => $request->comment ?? "", 
            'status' => '1' 
        ]); 
        
        $result = Helper::getStoreId() == Helper::getStoreId() ? true : false;
        foreach (Session::get('openingStock') as $id => $product)
        {
            $discount =   UserStore::find(Helper::getStoreId())->role->retailModel->discount;
            $finalAmounts = StoreHelper::getFinalAmounts(Helper::getStoreId(),$product,$result); 
            LedgerDetail::create([ 
                'ledger_id' => $ledger->id,
                'product_stock_id' => $product['id'],
                'gin' => $product['gin'],
                'weight' => InvoiceDetailGradeProduct::find($product['id'])->weight ?? "0",
                'product_unit_qty' => $product['productStockRatti'],
                'product_unit_rate' => $product['rattiRate'],
                'ledger_status' => 1,

                'product_amount' => $product['mrpAmount'], 

                'discount_id' =>  $result ? 0 : $discount->id,
                'discount_amount' => $finalAmounts['discountAmount'] ,
                'discount_rate' => $result ? 0 : $discount->rate,
                'amount_with_discount' => $finalAmounts['amountWithDiscount'],

                'tax_type_id' =>  $finalAmounts['taxTypeId'],
                'tax_rate' =>  $finalAmounts['taxRate'],
                'tax_amount' =>  $finalAmounts['taxAmount'],
                'ratti_rate_without_tax' =>  $finalAmounts['rattiRateWithoutTax'],
                'mrp_without_tax' =>  $finalAmounts['mrpWithoutTax'],

                'total_amount' => $finalAmounts['finalAmount'],
            ]);
            $this->productOutStock($product['id']);
        }  
        $ledgerId = $ledger->id;
        
        $productsAmount = $ledger->countProductAmount($ledgerId);
        $rattiRateWithoutTax = $ledger->countRattiRateWithoutTax($ledgerId);
        $mrpWithoutTax = $ledger->countMrpWithoutTax($ledgerId);
        $discount = $ledger->countTotalDiscount($ledgerId);
        $amountWithDiscount = $ledger->countAmountWithDiscount($ledgerId);
        $tax = $ledger->countTotalTax($ledgerId);
        $totalAmount = $ledger->countTotalAmount($ledgerId);
        $totalQty = $ledger->countTotalQty($ledgerId);
        
        Ledger::where('id',$ledgerId) ->update([
            'products_amount' => $productsAmount,
            'ratti_rate_without_tax' => $rattiRateWithoutTax,
            'mrp_without_tax' => $mrpWithoutTax,
            'discount_amount' => $discount,
            'amount_with_discount' => $amountWithDiscount,
            'tax_amount' => $tax,
            'total_amount' => $totalAmount,
            'qty_total' => $totalQty,
        ]);
        Session::forget('openingStock');
        Session::forget('notExistProducts');
        Session::forget('outOfStockProducts'); 
        // $this->savePdfReport($ledger->id);
        DB::commit(); 
    }catch(\Exception $e){       
        DB::rollback();
        return response()->json(['success'=> false]);
        dd($e); 
    }
        return response()->json(['success'=> true,'redirectUrl'=> route('ledgerMedia.index',$ledger->id)]);
    }
    
    public function saveGin($gin)
    {  
        $productStock = InvoiceDetailGradeProduct::query()
                    ->with('productGrade:id,alias', 'product:id,name', 'ratti:id,rati_standard,rati_big')
                    ->select('id', 'gin', 'product_id', 'product_category_id', 'grade_id', 'ratti_id', 'weight', 'in_stock')
                    ->where(['gin' => $gin])
                    ->first() ?? false;
        
        if(!$productStock){
            return 'Not Exist';
        }elseif($productStock->in_stock == 0){
            return 'Out of Stock';
        }else{
            $openingStockSession = Session::get('openingStock');
            if (!$openingStockSession)
            {
                return $this->setSessionEmptty($productStock);
            }
            if(isset($openingStockSession[$productStock->id])){
                return 'Product Already Added';
            }

            $productRate = StoreHelper::getProductGradeRattiRattiRateMrpAmount($productStock);
            $openingStockSession[$productStock->id] = [
                    'id' => $productStock->id,
                    'gin' => $productStock->gin, 
                    'product' => $productStock->product->name, 
                    'grade' => $productStock->productGrade->alias ??'', 
                    'ratti' => $productStock->ratti->rati_standard??"", 
                    'productStockRatti' => $productRate['productStockRatti'],
                'rattiRate' => $productRate['rattiRate'],
                'mrpAmount' => $productRate['mrpAmount'], 
                'productStockId' => $productRate['productStockId'], 
            ];
            Session::put('openingStock', $openingStockSession);
            
            return 'success';
        }
    }

    public function setSessionEmptty($productStock)
    {
        $productRate = StoreHelper::getProductGradeRattiRattiRateMrpAmount($productStock);

        $openingStockSession = [$productStock->id => [
            'id' => $productStock->id,
            'gin' => $productStock->gin, 
            'product' => $productStock->product->name, 
            'grade' => $productStock->productGrade->alias ??'', 
            'ratti' => $productStock->ratti->rati_standard??"", 
            'productStockRatti' => $productRate['productStockRatti'],
                'rattiRate' => $productRate['rattiRate'],
                'mrpAmount' => $productRate['mrpAmount'],
                'productStockId' => $productRate['productStockId'],
            ]
        ];
        Session::put('openingStock', $openingStockSession); 
        return 'Success';
    }
 

    public function productOutStock($productStockId)
    {
        return InvoiceDetailGradeProduct::find($productStockId)
            ->update(['in_stock' => 0]);
    }

    public function productInStock($id)
    {
        return InvoiceDetailGradeProduct::find($id)->update(['in_stock' => 1]);
    }
    
    public function savePdfReport($ledgerId){
        $ledger = Ledger::find($ledgerId); 
        $ledgerDetails = LedgerDetail::select('id', 'ledger_id', 'gin', 'product_stock_id', 'product_unit_qty', 'product_unit_rate', 'product_amount')->has('ledger')
            ->with(['ledger:id,voucher_number', 'productStock'])
            ->where(['ledger_id' => $ledgerId])->get();
        $pdf = PDF::loadView('burberry2', array('ledger'=>$ledger,'ledgerDetails'=>$ledgerDetails)); 

        $pdf->setOptions(['isPhpEnabled' => true,'isRemoteEnabled' => true]); 
        $filename = "generatepdf.pdf"; 
        $pdf->save($ledger,'images');
    }

    
}

