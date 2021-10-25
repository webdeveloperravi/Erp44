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

class PurchaseOrderRequestController extends Controller
{  

    public function index()
    {   
        $managers = Helper::getManagersByTree(); 
        return view('store.PurchaseOrderRequest.index',compact('managers'));
    }

    public function all($userId)
    {    
        if($userId == 'all'){
            // dd('saab');
            $authUser = UserStore::find(auth('store')->user()->id);
            if($authUser->type == 'lab' || $authUser->type == 'org'){
                
                $userId = StoreHelper::getStoreId();
                $managerIds = UserStore::where(['org_id'=>$userId,'type'=>'user'])->pluck('id')->toArray(); 
                $purchaseOrderRequests = StorePurchaseOrder::query()
                                                ->where('seller_store_id',StoreHelper::getStoreId()) 
                                                // ->where('approved',0)
                                                // ->orWhere('approved_by',array_merge($managerIds,[$authUser->id]))
                                                ->get();

            }elseif($authUser->type == 'user'){
              
             $managerIds = Helper::getSubRolesManagerIds();  
                                       
             $purchaseOrderRequests = StorePurchaseOrder::query()
                                                ->where('seller_store_id',StoreHelper::getStoreId()) 
                                                // ->where('approved',0)
                                                // ->orWhere('approved_by',array_merge($managerIds,[$authUser->id]))
                                                ->get();
            }
        }else{ 
        $purchaseOrderRequests = StorePurchaseOrder::query()
                                            ->where('seller_store_id',StoreHelper::getStoreId()) 
                                            ->where('approved',0)
                                            ->orWhere('approved_by',auth('store')->user()->id)
                                            ->get();
        } 
        return view('store.PurchaseOrderRequest.all', compact('purchaseOrderRequests'));
    } 

    public function view($id)
    {
        $purchaseOrderRequestsIds = StorePurchaseOrder::where('seller_store_id',StoreHelper::getStoreId())
                                    ->get()
                                    ->pluck('id')
                                    ->toArray()
                                    ;
        if(in_array($id,$purchaseOrderRequestsIds)){
            $purchaseOrderRequest = StorePurchaseOrder::find($id);
            $products = ProductCategory::find(2)->Product;
            $unitId = StoreHelper::getUserStoreById($purchaseOrderRequest->buyer_store_id)->role->unit->id ?? 2;
            if($unitId == 2)
            {
                $ratties = ProductMWeightRange::get();
            }
            else if($unitId==3)
            {
                $ratties = ProductMWeightRange::all()->unique('rati_big');
            }
            return view('store.PurchaseOrderRequest.view',compact('purchaseOrderRequest','products','ratties'));
        }else{
            abort(404);
        }
    }

    public function viewDetail($id)
    { 
            $purchaseOrderRequest = StorePurchaseOrder::find($id);
            return view('store.PurchaseOrderRequest.viewDetails',compact('purchaseOrderRequest')); 
    }

    public function editQty($id)
    { 
        $detail = StorePurchaseOrderDetail::find($id);
        return view('store.PurchaseOrderRequest.editQty',compact('detail'));
    }

    public function updateQty(Request $request)
    {
        $saleOrderDetail = StorePurchaseOrderDetail::where('id',$request->detailId)->first();
        $saleOrderDetail->update(['confirmed_qty'=>$request->qty]); 
    }

    public function deleteDetail($id)
    { 
        StorePurchaseOrderDetail::find($id)->delete(); 
        return response()->json(['success'=>true,'msg'=> 'Successfully Deleted']);
    }

    public function saveDetail(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'product' => 'required|not_in:0',
            'grade' => 'required|not_in:0',
            'ratti' => 'required|not_in:0',
            'quantity' => 'required',
        ]);
        if($validator->passes()){

        StorePurchaseOrderDetail::create([
            // 'temp_number' => Session::get('temp_number'),
            'store_purchase_order_id' => $request->orderId,
            'product_category_id' => 2,
            'product_id' => $request->product,
            'grade_id' => $request->grade,
            'ratti_id' =>  $request->ratti,
            'quantity' =>  $request->quantity,
            'confirmed_qty'=> $request->quantity,
        ]);
        }else{
            $keys = $validator->errors()->keys();
            $vals  = $validator->errors()->all();
            $errors = array_combine($keys,$vals); 
            return response()->json(['errors'=>$errors]);
        }
        return response()->json(['success'=>true,'msg'=> 'Successfully Saved']);
    }

    public function approve(Request $request)
    {
        $order = StorePurchaseOrder::find($request->orderId) ?? false;
        if($order){
            $order->update(['approved'=> 1,'approved_by'=>auth('store')->user()->id,'so_number' => Helper::getSoNumber(StoreHelper::getStoreId())]);
        }
        
        return response()->json(['success'=>true,'msg'=> 'Successfully Approved']);
    }
     
}

