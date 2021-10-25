<?php
namespace App\Http\Controllers\Admin\Master;

use Session;
use Validator;
use Illuminate\Http\Request;
use App\Model\Admin\Master\Product;
use App\Http\Controllers\Controller;
use App\Model\Admin\Master\ProductMGrade;
use App\Model\Admin\Master\ProductRateProfile;
use App\Model\Admin\Master\ProductMGrade as Grade;
use App\Model\Admin\Master\ProductGradeRateProfile;
use App\Model\Admin\Master\ProductCategory as ProductType;
use App\Model\Admin\Master\ProductRateProfile as RateProfile;

class ProductGradeRateProfileController extends Controller
{

    public function index()
    {
        $categories = Product::where(['parent_id'=> 0,'type_id'=>2])->orderBy('name', 'asc')->get(); 
        $rateprofiles = RateProfile::where('status', 1)->orderBy('parent_sort')->get(); 

        return view('admin.amaster.product_grade_rate_profile.index', compact('categories', 'rateprofiles'));

    }

    public function getGradeList($productId){
        
        $productMGrades = ProductMGrade::pluck('id')->toArray();
        $productGrades = ProductGradeRateProfile::where('product_id',$productId)->pluck('grade_id')->toArray();
        $unsignedGrades = ProductMGrade::whereIn('id',array_diff($productMGrades,$productGrades))->get();

        return view('admin.amaster.product_grade_rate_profile.gradeList',compact('unsignedGrades'));
    }

    public function getRateProfileList($productId)
    {
       
       $productRateProfiles = ProductRateProfile::pluck('id')->toArray();
        $productGradeRateProfiles = ProductGradeRateProfile::where('product_id',$productId)->pluck('rate_profile_id')->toArray();
        $unsignedRateProfiles = ProductRateProfile::whereIn('id',array_diff($productRateProfiles,$productGradeRateProfiles))->get();

        return view('admin.amaster.product_grade_rate_profile.rateProfileList',compact('unsignedRateProfiles'));

    }

    public function store(Request $req)
    {

        $messages = ['required' => 'The :attribute field is required'];
        $validation = Validator::make($req->all() , [
            'product_id' => 'required|not_in:Choose Product',
             'grade_id' => 'required|not_in:Choose Grade', 
             'rate_profile_id' => 'required|not_in:Choose Rate Profile'
        ],);
   
        if ($validation->fails())
        { 
            return response()->json(array(
                'success' => false,
                'failure' => $validation->messages()
            ) , 401);
        }
        else {
            $productGradePRofile = ProductGradeRateProfile::create([
                'product_id' => $req->product_id,
                'grade_id' => $req->grade_id,
                'rate_profile_id' => $req->rate_profile_id    
            ]);

            $productGradePRofile->masterIds()->create([
                'created_id' => auth('admin')->user()->id,
            ]);

         

            $response = ['success' => 'Your Data has been Successfully done.'];
            return response()->json($response, 200);
        }
    }

    public function getUnsignedGradesAndRateProfiles($productId)
    { 
        $grades =ProductGradeRateProfile::where(['product_id'=>$productId,'status'=>1])->pluck('grade_id')->toArray();
        $collection = collect($grades);
        $duplicateGradeData = $collection->duplicates()->toArray();
      
        $product = Product::find($productId);
        $productMGrades = ProductMGrade::pluck('id')->toArray();
        $productRateProfiles = ProductRateProfile::pluck('id')->toArray();
        
        
        $productGradeRateProfiles = ProductGradeRateProfile::where('product_id',$productId)->pluck('rate_profile_id')->toArray();
        $productGrades = ProductGradeRateProfile::where('product_id',$productId)->pluck('grade_id')->toArray();

        $unsignedGrades = ProductMGrade::whereIn('id',array_diff($productMGrades,$productGrades))->get();
        $unsignedRateProfiles = ProductRateProfile::whereIn('id',array_diff($productRateProfiles,$productGradeRateProfiles))->get();

        return view('admin.amaster.product_grade_rate_profile.assign_grade_list2',compact('product','unsignedGrades','unsignedRateProfiles','duplicateGradeData'));
    }

    public function editGradeRateProfile ($productId,$gradeId,$rateProfileId){
        
        $product = Product::find($productId);
        $grade = ProductMGrade::find($gradeId);
        $oldRateProfile = ProductRatePRofile::find($rateProfileId);

        $oldGradeRateProfile = ProductGradeRateProfile::where(['product_id'=>$productId,'grade_id'=> $gradeId,'rate_profile_id'=>$rateProfileId])->first();
         
        //Get Unsigned Rate Profiles
        $productRateProfiles = ProductRateProfile::pluck('id')->toArray();
        $productGradeRateProfiles = ProductGradeRateProfile::where('product_id',$productId)->pluck('rate_profile_id')->toArray();
        $unsignedRateProfiles = ProductRateProfile::whereIn('id',array_diff($productRateProfiles,$productGradeRateProfiles))->get();

        return view('admin.amaster.product_grade_rate_profile.editProductGradeRateProfile',compact('product','grade','oldRateProfile','unsignedRateProfiles','oldGradeRateProfile'));
    }


    // change Status 
    public function statusGradeRateProfile ($id){
        $statusGradeRateProfile = ProductGradeRateProfile::where(['id'=>$id])->first()->status;
        $status =0;
        if($statusGradeRateProfile){
            $status =0;
        }
        else
        {
           $status =1;
        }
        ProductGradeRateProfile::where(['id'=>$id])->update([
         'status'=>$status

        ]);
        return response()->json(['success'=>true,'msg' => 'Your Data has been Successfully Status Changed.'], 200);

       
    }

    public function updateProductGradeRateProfile(Request $request)
    {
        $statusDisable = ProductGradeRateProfile::where(['id' => $request->old_id])->update(['status' => 0]);
        $statusDisable = ProductGradeRateProfile::where(['id' => $request->old_id])->delete();
        
        $productGradePRofile = ProductGradeRateProfile::create([
            'product_id' => $request->product_id,
            'grade_id' => $request->grade_id,
            'rate_profile_id' => $request->rate_profile_id    
        ]);

        $productGradePRofile->masterIds()->create([
            'updated_id' => auth('admin')->user()->id,
        ]);
         
        return response()->json(['success'=>true,'msg' => 'Your Data has been Successfully Updated.'], 200);
    }
 

    // showing only top design part this function
    public function view()
    {
        //dd(123);
        $categories = Product::where(['parent_id'=> 0,'type_id'=>2])->orderBy('name', 'asc')
            ->get();
        // $cate_grade_rate=ProductGradeRateProfile::where('status',1)->get();
        return view('admin.amaster.product_grade_rate_profile.view', compact('categories'));
    }

    protected function viewAll(Request $request)
    {

        //  dump($request->all());
        $grade_assign = $grade_unassign = null;
        $grade_check = null;
        $profile_assign = $profile_unassign = null;
        if (!empty($request['grade']['assigned']))
        {
            $grade_assign = true;

        }
        if (!empty($request['grade']['unassigned']))
        {
            $grade_unassign = true;

        }

        if (!empty($request['profile']['assigned']))
        {
            $profile_assign = true;
        }
        if (!empty($request['profile']['unassigned']))
        {
            $profile_unassign = true;
        }

        $filter['parent_id'] = 0;
        $filter['status'] = 1;
        if ($request['cate_id'] > 0)
        {

            $filter['id'] = $request['cate_id'];
            //$filter['']
            
        }

        // dd($filter);
        $cat = Product::where($filter)->where('type_id',2)->orderBy('name', 'asc')
            ->get();

        $cate_grade_rate = ProductGradeRateProfile::where(['status' => 1])->get();

        //dd($cat,$cate_grade_rate);
        return view('admin.amaster.product_grade_rate_profile.assigned_view_record', compact('cate_grade_rate', 'cat', 'grade_assign', 'grade_unassign', 'profile_assign', 'profile_unassign'));

    }

    

}

