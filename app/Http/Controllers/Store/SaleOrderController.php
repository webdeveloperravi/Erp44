<?php

namespace App\Http\Controllers\Store;
use App\Helpers\Helper; 
use App\Helpers\StoreHelper;
use Illuminate\Http\Request;
use App\Model\Guard\UserStore;
use App\Model\Store\StoreZone;  
use App\Model\Admin\Master\Product; 
use App\Http\Controllers\Controller;
use App\Model\Store\StorePurchaseOrder;
use Illuminate\Support\Facades\Session; 
use App\Model\Admin\Master\ProductMGrade; 
use Illuminate\Support\Facades\Validator;
use App\Model\Admin\Organization\ZoneCity;
use App\Model\Admin\Master\ProductCategory;
use App\Model\Store\StorePurchaseOrderDetail;
use App\Model\Admin\Master\ProductMWeightRange; 

class SaleOrderController extends Controller
{    

    public function index()
    {   
        $managers = Helper::getManagersByTree(); 
        return view('store.SaleOrder.index',compact('managers'));
    }

    public function all($userId)
    {   
        // if($userId == 'all'){
        //     $authUser = UserStore::find(auth('store')->user()->id);
        //     if($authUser->type == 'lab' || $authUser->type == 'org'){
                
        //         $userId = StoreHelper::getStoreId();
        //         $managerIds = UserStore::where(['org_id'=>$userId,'type'=>'user'])->pluck('id')->toArray(); 

        //         $saleOrders  = StorePurchaseOrder::where('seller_store_id',$userId)
        //                        ->whereIn('created_by',array_merge($managerIds,[$authUser->id]))
        //                        ->latest()->get();

        //     }elseif($authUser->type == 'user'){
              
        //      $managerIds = Helper::getSubRolesManagerIds();  
                                       
        //             $saleOrders  = StorePurchaseOrder::where('seller_store_id',$userId)
        //                         ->whereIn('created_by',array_merge($managerIds,[$authUser->id]))
        //                         ->latest()->get();
        //     }
        // }else{ 
        //     $saleOrders  = StorePurchaseOrder::where('seller_store_id',StoreHelper::getStoreId())
        //                     ->where('created_by',$userId)
        //                     ->latest()->get(); 
        // } 
        $authUser =  auth('store')->user();
        if(in_array($authUser->type,['org','lab'])){
           
           $childRetailModels = $authUser->role->retailModel->getAllChildren();
           $storeZoneIds = $authUser->zones->pluck('id')->toArray();
           $zoneCities = ZoneCity::whereIn('zone_id',$storeZoneIds)->get()->pluck('city_id')->toArray(); 
           $storeIds = UserStore::query()
                       ->whereHas('primaryAddress',function($q) use ($zoneCities){
                           $q->whereIn('city_id',$zoneCities);
                       })
                       ->whereHas('role',function($q) use ($childRetailModels){
                           $q->whereHas('retailModel',function($q) use ($childRetailModels){
                                      $q->whereIn('id',$childRetailModels);
                           });
                       })
                       ->get()
                       ->pluck('id')
                       ->toArray()
                       ;
           $saleOrders = StorePurchaseOrder::query()
                               ->whereIn('buyer_store_id',$storeIds)
                               ->orWhere('buyer_store_id',StoreHelper::getStoreId())
                               ->latest()->get(); 

        }elseif($authUser->type == 'user'){
           $storeZoneIds = $authUser->managerZones->pluck('id')->toArray();
           $zoneCities = ZoneCity::whereIn('zone_id',$storeZoneIds)->get()->pluck('city_id')->toArray(); 
           $storeIds = UserStore::query()
                       ->whereHas('primaryAddress',function($q) use ($zoneCities){
                           $q->whereIn('city_id',$zoneCities);
                       }) 
                       ->get()
                       ->pluck('id')
                       ->toArray()
                       ;
           $saleOrders = StorePurchaseOrder::query()
           ->whereIn('buyer_store_id',$storeIds)
           ->orWhere('buyer_store_id',StoreHelper::getStoreId())
           ->latest()->get(); 
        }
        return view('store.SaleOrder.all', compact('saleOrders'));
    } 

    public function view($id)
    {
        $saleOrder = StorePurchaseOrder::find($id);
        return view('store.SaleOrder.view',compact('saleOrder'));
    }

    public function updateQuantity(Request $request)
    {
        
        $saleOrderDetail = StorePurchaseOrderDetail::where('id',$request->id)->first();
        $saleOrderDetail->update(['confirmed_qty'=>$request->qty]); 
    }

    public function create() 
    {   
        if(Session::has('temp_number')){
            return view('store.SaleOrder.create');
        }else{
            $tempNumber = rand(000000,999999);
            Session::put('temp_number',$tempNumber);
            return view('store.SaleOrder.create');
        }
    }
    
    public function createPage() 
    {    
         
        $productCategories = ProductCategory::all();
        $grades =ProductMGrade::all();
        $unitId = UserStore::find(StoreHelper::getStoreId())->role->unit->id; 
        if($unitId == 2)
        {
            $ratties = ProductMWeightRange::get();
        }
        else if($unitId==3)
        {
            $ratties = ProductMWeightRange::all()->unique('rati_big');
        }

        $myStoreId = \App\Helpers\StoreHelper::getStoreId(); 
        $zoneIds = StoreZone::where('store_id',$myStoreId)->pluck('zone_id')->toArray();
        $zoneCities = ZoneCity::whereIn('zone_id',$zoneIds)->pluck('city_id')->toArray(); 
        $buyers = UserStore::whereHas('addresses',function($q) use ($zoneCities){
            $q->where('address_type_id',1)->whereIn('city_id',$zoneCities);
            })->where('type','org')->orWhere('type','lab')
            ->with('headOfficeAddress.city:id,name')
            ->orderBy('company_name')
          ->get();
        return view('store.SaleOrder.createPage',compact('buyers','productCategories','grades','ratties'));
    } 

    public function getProducts($productCategoryId){
        $products = ProductCategory::find($productCategoryId)->Product;
        return view('store.SaleOrder.products',compact('products'));
    }

    public function getGrades($productId){
        $grades = Product::find($productId)->grade;
        return view('store.SaleOrder.grades',compact('grades'));
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
                    $data->update(['quantity' =>$newQuantity,'confirmed_qty'=>$newQuantity ]);
               }
               else
               {
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
            return view('store.SaleOrder.alldetails',compact('orderDetails'));
        }
    }

    public function purchaseOrderDetailDelete($id){
        $detail = StorePurchaseOrderDetail::where('id',$id)->first()->delete();
        return response()->json(['success'=>true]);
    }

    
    public function placeOrder($buyerId)
    {  
       $number = StorePurchaseOrder::orderBy('id','desc')->first()->number ?? "122233";
       $purchaseOrder = StorePurchaseOrder::create([
            'so_number'=> Helper::getSoNumber(StoreHelper::getStoreId()),
            'po_number'=> Helper::getPoNumber(StoreHelper::getStoreId()),
            'seller_store_id'=>auth('store')->user()->id,
            'buyer_store_id'=>  $buyerId,
            'created_by' => auth('store')->user()->id,
            'approved' => 1,
            'approved_by' => auth('store')->user()->id,
            
        ]);

        $orderDetails = StorePurchaseOrderDetail::where('temp_number',Session::get('temp_number'))->get();
        foreach($orderDetails as $detail){
            $detail->update(['store_purchase_order_id'=> $purchaseOrder->id,'temp_number'=>null]);
        }
        Session::forget('temp_number');
        $msg = 'Your Order Placed Successfully. Your Sale Order Number is '. $purchaseOrder->so_number;
        return response()->json(['success'=>true,'msg'=> $msg]);
    }


             

   
}

