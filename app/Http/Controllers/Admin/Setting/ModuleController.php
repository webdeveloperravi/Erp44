<?php
namespace App\Http\Controllers\Admin\Setting;
use Auth;
use Validator;
use App\Helpers\Helper;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Model\Admin\Setting\Guard;
use Illuminate\Support\Collection;
use App\Model\Admin\Setting\Module;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

class ModuleController extends Controller
{
   
   public function index()
   {
     $guards = Guard::all();
     return view('admin.amaster.menu.index',compact('guards'));
   }

   protected  function moduleList(){
     
      $menu_list=Module::all();
      $guard=Guard::orderBy('parent_sort')->pluck('name','id');
     return view('admin.amaster.menu.menulist',compact('menu_list','guard'));
   }

   protected function parentMenu($id)
   {
     $gr_menu=Module::where('guard_id',$id)->orderBy('parent_sort','asc')->get();
     return view('admin.amaster.menu.parent_menu',compact('gr_menu'));
   }
 


   public function store(Request $request)
   {  

      $guard=1;
         
      $validator = Validator::make($request->all(),[
      'title'=>'required|min:2|max:255',
      'guard' =>'required|not_in:0',
      'route' => [ 
         function($attribute,$value,$fail){
            if(strlen($value) > 0){
               if(!Route::has($value)){
                  $fail('Invalid Route');
               }
            }
         },'unique:modules,route'
         ], 
      ]);

      if($validator->passes()){

      $user_id = Auth::guard('admin')->id();
      $parent_sort=0;
      $child_sort=0;
      $menus=Module::all();
      if(count($menus)==0) { $parent_sort=1; }

      if(empty($request->parent))
      {
         $parentsort_value=Module::where('parent', '0')->max('parent_sort');  
         $parent_sort=$parentsort_value+1;
      }
         
      if(!empty($request->parent))
      {
         // to fetch child_sort Max Value    
         $child_sort_value=Module::where('parent', $request->parent)->max('child_sort');  
         $child_sort=$child_sort_value+1;
      }
         
         
      $menus=new Module();
      $menus->title=$request->title;
      $menus->description=$request->description;
      $menus->route=$request->route;
      $menus->parent=$request->parent;
      $menus->parent_sort=$parent_sort;
      $menus->child_sort=$child_sort;
      $menus->created_by=$user_id;
      $menus->guard_id=$request->guard;
      $menus->save();
      $menus->masterIds()->create([
      'created_id' => Helper::getAdminId()
      ]);

      return response()->json(['success'=>true ],200);
      }else{
         $keys = $validator->errors()->keys();
         $vals  = $validator->errors()->all();
         $errors = array_combine($keys,$vals);
         return response()->json(['errors'=>$errors]);
      }
   }

   public function edit($id)
   {     
      $module= Module::find($id);
      $parent_modules=Module::where('guard_id',$module->guard_id)->get();  
      $guard = Guard::find($module->guard_id);
      return view('admin.amaster.menu.edit_module',compact('module','parent_modules','guard'));
   }

   public function update(Request $request)
   {
           
         $validator = Validator::make($request->all(),[
            'title'=>'required|min:2|max:255',
            'guard' =>'required|not_in:0', 
         ]);
         if($validator->passes()){
            $parent_sort=0;
            $child_sort=0;
           if(empty($request->parent))
            {
            $parentsort_value=Module::where('parent', '0')->max('parent_sort');  
            $parent_sort=$parentsort_value+1;
             }
             if(!empty($request->parent))
             {
             // to fetch child_sort Max Value    
             $child_sort_value=Module::where(['parent'=> $request->parent])->latest()->value('child_sort'); 
              $child_sort=$child_sort_value+1;
             }
             // Same Parent  Name   Dont cretae Parent Menu Assign
             if($request->parent==$request->edit_id)
             {
              return response()->json(['success'=>Helper::message_format('Dont Create Child because Its Parent Root','danger')],200); 
             }
             if($request->parent==$request->parent_id)
              {
               
               $module =Module::where(['id'=>$request->edit_id])->first();
               $module->update(['title'=>$request->title,'route'=>$request->route,'parent'=>$request->parent,'guard_id'=>$request->guard, 'description' =>$request->description]);
               $module->masterIds()->create([
                  'updated_id' =>Helper::getAdminId()
             ]);
               return response()->json(['success'=>Helper::message_format('Record Updated','primary')],200);

              }
              elseif ($request->parent!=$request->parent_id) {
                
             $childsort=Module::where(['parent'=>$request->parent])->max('child_sort')+1;
           
           
             $module= Module::where(['id'=>$request->edit_id])->first();
             $module->update(['title'=>$request->title,'route'=>$request->route,'parent'=>$request->parent,'guard_id'=>$request->guard_id, 'description' =>$request->description, 'child_sort'=>$childsort]);
             $module->masterIds()->create([
               'updated_id' =>Helper::getAdminId()
          ]);
              return response()->json(['success'=>Helper::message_format('Record Updated','primary')],200);
              }
         }else{
            $keys = $validator->errors()->keys();
            $vals  = $validator->errors()->all();
            $errors = array_combine($keys,$vals);
            return response()->json(['errors'=>$errors]);
          }
   }

     
   public function parentSort(Request $request)
   {
        $psort=$request->parent_id;
        $parentsort=1;
       
         foreach ($psort as $ps_key => $ps_val) {
            Module::where(['id'=>$ps_val])->update(['parent_sort'=>$parentsort]);
            $parentsort++;
         }
          return response()->json(["success"=>"Parent Sort Updated"]);
   }  

   public function childSort(Request $request)
   {
             
      if($request->child_id)
      {
        $csort=$request->child_id;
        $childsort=1;
        foreach ($csort as $cs_key => $cs_val) {
          Module::where(['id'=>$cs_val])->update(['child_sort'=>$childsort]);
          $childsort++;
         }
         } elseif($request->sub_child_id) {
                  $csort=$request->sub_child_id;
                  $sub_childsort=1;
         foreach ($csort as $cs_key => $cs_val) {
      
            Module::where(['id'=>$cs_val])->update(['child_sort'=>$sub_childsort]);
            $sub_childsort++;
         }
         }
         elseif($request->sub_sub_child_id)
         {
         $csort=$request->sub_sub_child_id;
         $sub_sub_childsort=1;
         foreach ($csort as $cs_key => $cs_val) {
          Module::where(['id'=>$cs_val])->update(['child_sort'=>$sub_sub_childsort]);
          $sub_sub_childsort++;
         }
         }
         return response()->json(["success"=>"Child Sort Updated"]);
   }  

   public function destroy($id)
   {
      $status=0;
      Module::find($id)->update(['status'=>$status]);
      Module::where('id', $id)->delete();  
      return response()->json(['success'=>Helper::message_format('Record Deleted','danger')],200);
   }

}
