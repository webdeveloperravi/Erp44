<?php
namespace App\Http\Controllers\Store;
use App\Helpers\Helper;
use App\Helpers\StoreHelper;
use Illuminate\Http\Request;
use App\Model\Guard\UserStore;
use App\Model\Store\StoreZone;
use App\Model\Store\PaymentLedger;
use App\Model\Admin\Master\Product;
use App\Model\Store\StoreSaleOrder;
use App\Http\Controllers\Controller;
use App\Model\Store\StorePurchaseOrder;
use Illuminate\Support\Facades\Session;
use App\Model\Admin\Master\ProductMGrade;
use App\Model\Store\StoreSaleOrderDetail;
use Illuminate\Support\Facades\Validator;
use App\Model\Admin\Organization\ZoneCity;
use App\Model\Store\StoreSaleOrderChallan;
use App\Model\Store\StoreSaleOrderPayment;
use App\Model\Admin\Master\ProductCategory;
use App\Model\Store\StorePurchaseOrderDetail;
use App\Model\Admin\Organization\StoreAddress;
use App\Model\Store\StoreSaleOrderPaymentType;
use App\Model\Admin\Master\ProductMWeightRange;
use App\Model\Warehouse\InvoiceDetailGradeProduct;

class PurchaseOrderController extends Controller
{    
   
    public function index()
    {   
        return view('store.PurchaseOrder.index');
    }
    
    public function create() 
    {   
        if(Session::has('temp_number')){
            return redirect()->route('purchaseorder.createorder');
        }else{
            $tempNumber = rand(000000,999999);
            Session::put('temp_number',$tempNumber);
            return redirect()->route('purchaseorder.createorder');
        }
    }
                    
    public function createOrder(){
        return view('store.PurchaseOrder.create');
    }
    
    public function createPage() 
    {    
        $myStoreId = \App\Helpers\StoreHelper::getStoreId();
        $myStoreCityId = StoreAddress::whereAddressTypeId('1')->where('store_id',$myStoreId)->first()->city_id; 
        if(ZoneCity::whereCityId($myStoreCityId)->exists()){ 
            $zoneId = ZoneCity::whereCityId($myStoreCityId)->first()->zone_id;
            $zoneStoreIds = StoreZone::whereZoneId($zoneId)->pluck('store_id')->toArray(); 
            $parentStores = UserStore::with('role.retailModel.retailType')->whereIn('id',$zoneStoreIds)
            ->whereHas('role',function($q){
                $q->whereHas('retailModel',function($q){
                    $q->whereHas('retailType',function($q){
                        $q->where('id',1);
                    });
                });
            })->where('type','org')->orWhere('type','lab')
            ->get();   
        }else{
            $parentStores = UserStore::where('id',1001)->get();
        }

        $productCategories = ProductCategory::all();
        // $grades =ProductMGrade::all();
        
        $unitId = auth('store')->user()->role->unit->id ?? 2;

        if($unitId == 2)
        {
            $ratties = ProductMWeightRange::get();
        }
        else if($unitId==3)
        {
            $ratties = ProductMWeightRange::all()->unique('rati_big');
        }
        
        return view('store.PurchaseOrder.createPage',compact('parentStores','productCategories','ratties'));
    } 

    public function getGrades($productId){
        $grades = Product::find($productId)->grade;
        return view('store.PurchaseOrder.grades',compact('grades'));
    }
    
    public function getProducts($productCategoryId){
        $products = ProductCategory::find($productCategoryId)->Product;
        return view('store.PurchaseOrder.products',compact('products'));
    }
    
    public function storePurchaseOrderDetail(Request $request)
    {   
 
        $validator = Validator::make($request->all(),[
            'product_category' => 'required|not_in:0',
            'product' => 'required|not_in:0',
            'grade' => 'required|not_in:0',
            'ratti' => 'required|not_in:0',
            'quantity' => 'required',
        ]);
        if($validator->passes()){
               if(StorePurchaseOrderDetail::where([
                                'temp_number'=>Session::get('temp_number'),
                                'product_category_id' => $request->product_category,
                                'product_id' => $request->product,
                                'grade_id' => $request->grade,
                                'ratti_id' =>  $request->ratti])->exists())
                {
                 $data = StorePurchaseOrderDetail::where([
                                'temp_number'=>Session::get('temp_number'),
                                'product_category_id' => $request->product_category,
                                 'product_id' => $request->product,
                                 'grade_id' => $request->grade,
                                'ratti_id' =>  $request->ratti])->first();

                    $oldQuantity = $data->quantity;
                    $newQuantity = $oldQuantity + $request->quantity;
                    $data->update(['quantity' =>$newQuantity ,'confirmed_qty' => $newQuantity ]);
               }else{
                    StorePurchaseOrderDetail::create([
                    'temp_number' => Session::get('temp_number'),
                    'product_category_id' => $request->product_category,
                    'product_id' => $request->product,
                    'grade_id' => $request->grade,
                    'ratti_id' =>  $request->ratti,
                    'quantity' =>  $request->quantity,
                    'confirmed_qty'=> $request->quantity,
                    ]);
                return response()->json(['success'=>true]);
            } 
        }else{
            $keys = $validator->errors()->keys();
            $vals  = $validator->errors()->all();
            $errors = array_combine($keys,$vals);
           return response()->json(['errors'=>$errors]);
        }
    }

    public function getAllPurchaseOrderDetails(){
        
        if(Session::get('temp_number') > 0){
           $orderDetails =  StorePurchaseOrderDetail::where('temp_number',Session::get('temp_number'))->get();
            return view('store.PurchaseOrder.alldetails',compact('orderDetails'));
        }
    }

    public function purchaseOrderDetailDelete($id){
        $detail = StorePurchaseOrderDetail::where('id',$id)->first()->delete();
        return response()->json(['success'=>true]);
    }

    public function placeOrder(Request $request)
    {   
         
        
        $validator = Validator::make($request->all(),[
            'vendor' => 'required|not_in:0', 
        ]);
        if($validator->passes()){

            $purchaseOrder = StorePurchaseOrder::create([
                 'po_number'=> Helper::getPoNumber(StoreHelper::getStoreId()), 
                 'seller_store_id'=> $request->vendor,
                 'buyer_store_id'=> \App\Helpers\StoreHelper::getStoreId(),
                 'created_by' => auth('store')->user()->id,
             ]);
     
             $orderDetails = StorePurchaseOrderDetail::where('temp_number',Session::get('temp_number'))->get();
             foreach($orderDetails as $detail){
                 $detail->update(['store_purchase_order_id'=> $purchaseOrder->id,'temp_number'=>null]);
             }
             Session::forget('temp_number');
             $msg = 'Your Order Placed Successfully. Your Purchase Order Number is '. $purchaseOrder->po_number;
             return response()->json(['success'=>true,'msg'=> $msg]);
        }else{
            $keys = $validator->errors()->keys();
            $vals  = $validator->errors()->all();
            $errors = array_combine($keys,$vals);
           return response()->json(['errors'=>$errors]);
        }
    }

    public function allOrders(){
      $orders =  StorePurchaseOrder::query()
                          ->with('createdBy:id,name')
                          ->where('created_by',auth('store')->user()->id)
                          ->latest()
                          ->get()
                          ;
      
     return view('store.PurchaseOrder.allorders',compact('orders'));
    }

    public function orderView($id){
        $order = StorePurchaseOrder::find($id); 

        if(auth('store')->user()->id == $order->buyer_store_id){
            return view('store.PurchaseOrder.orderView',compact('order','id'));
        }else{
            abort(404);
        }
    }

    public function viewAll($id){
       
        $storeSaleOrder = StoreSaleOrder::where('store_purchase_order_id',$id)->first();
       return view('store.PurchaseOrder.allView',compact('storeSaleOrder'));  
    }

    public function purchaseOrderDetailedit($id){
       $parentStore = UserStore::find(auth('store')->user()->id)->parentStore ?? 'GemLeb';
        $productCategories = ProductCategory::all();
        $products = Product::all();
        $grades =ProductMGrade::all();
        $unitId = auth('store')->user()->role->unit->id;
        if($unitId == 2)
        {
            $ratties = ProductMWeightRange::get();
        }
        else if($unitId==3)
        {
            $ratties = ProductMWeightRange::all()->unique('rati_big');
        }
        $detailEdit = StorePurchaseOrderDetail::where('id',$id)->first();
        return view('store.PurchaseOrder.editorderdetail',compact('detailEdit','parentStore','productCategories','products','grades','unitId','ratties'));
    }

    public function updatePurchaseOrderDetail(Request $request)
    {
        // dd($request->all());
      $update = StorePurchaseOrderDetail::where(['id'=>$request->order_id])->update([
            
            'product_id' => $request->product,
            'grade_id' => $request->grade,
            'ratti_id' => $request->ratti,
            'quantity' => $request->quantity,
            'confirmed_qty' => $request->quantity,

        ]);  
      return response()->json(['success'=>true]);
    }

    
    public function orderDetail($orderId)
    {
        $order = StorePurchaseOrder::find($orderId);
      return view('store.PurchaseOrder.purchaseOrderDetails',compact('order'));
    }

    public function receivedAllOrders(){

   $orders =  StorePurchaseOrder::where('seller_store_id',auth('store')->user()->id)->orderBy('created_at','desc')->get();
     
     return view('store.PurchaseOrder.receivedOrder',compact('orders'));
    }


   


  

}
