<?php

namespace App\Http\Controllers\Admin\Master;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Admin\Setting\DepartmentUserRole as AdminRole;
use App\Model\Admin\Setting\Guard;
use App\Model\Guard\UserAdmin;
use App\Model\Guard\UserWarehouse;
use App\Model\Guard\UserOperation;
use App\Model\Guard\UserSale;
use App\Model\Guard\UserStore;
use App\Helpers\Helper;
use App\Helpers\UserSystemInfoHelper;
use Auth;
use Hash;
use Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrgLeadEmailCode;
use App\Mail\WelcomeKitEmail;
use Route;
use App\Model\Admin\Master\CountryCode;
class DepartmentUserController extends Controller
{    

     public function index()
     { 
      // $get_ip =  UserSystemInfoHelper::get_ip();
      // $get_browser = UserSystemInfoHelper::get_browsers();
      // $get_os = UserSystemInfoHelper::get_os();
      // $get_dis =  UserSystemInfoHelper::get_device();
      $country_code = CountryCode::all();
      $guard=Guard::all();
       return view('admin.amaster.department_user.index',compact('guard','country_code'));
     }





     protected function getRole($guard_id)
     {    
      $role =  UserWarehouse::where('role_id',1)->exists(); 
       if($role){
         $all_role['role']=AdminRole::where('name','!=','Super')->pluck('name','id');
      }else{
        $all_role['role']=AdminRole::where(["guard_id"=>$guard_id])->pluck('name','id');
      }
          return response()->json($all_role);
     }
    

   protected function reg_email_verify(Request $request){
              
             $table_name = $this->getGuardTabName($request->role);
             $validator = Validator::make($request->all(), [
              'department' => 'required|not_in:Select Department',
              'role' => 'required|unique:'.$table_name.',role_id,not_in:Select Role',
              'country' => 'required|not_in:Select Country',
              'email' => 'email|required|email',
              'name' => ['required'],
              'phone' => ['required'],
             
            ]);
       
               if ($validator->fails()){
                  
                   return response()->json(["error"=>true,"message"=>$validator->errors()->all()],401);
               }
               else
               {
                    $message=$this->check_email($request->email,$request->phone);

                   
                     if($message!='')
                     {
                     return response()->json(['success'=>Helper::message_format($message,'danger'), 'flag'=>true],200);
                       } 
              
                   $otp_code=Helper::generateNumericOTP(6);
                    if($this->send_otp($otp_code,$request->email))
                    {

              $user_id = Auth::guard('admin')->id();
                 $table_name::create([
                 'guard_id' => $request->department,
                 'role_id' => $request->role,
                 'name' => $request->name,
                 'email' => $request->email,
                 'whats_app' => $request->phone,
                 'whats_app_country_phone_code_id' => $request->country,
                 'created_by' =>$user_id
                ]);

                return response()->json(['success'=>true]);
                }
               }
   }


     public function store(Request $request)
     {

      
        $table_name = $this->getGuardTabName($request->role); 
                $validator = Validator::make($request->all(),[
                'department' => 'required|not_in:Select Department',
               // 'role' => 'required|unique:'.$table_name.',role_id,not_in:Select Role',
                 'role' =>'required|not_in:Select Role',
                'country' => 'required|not_in:Select Country',
                'email' => 'email|required|email',
                'name' => ['required'],
                'phone' => ['required'],
                ]);
        
      if($validator->passes()){
      
     $user_id = Auth::guard('admin')->id();
                 $table_name::create([
                 'guard_id' => $request->department,
                 'role_id' => $request->role,
                 'name'=> $request->name,
                 'email'=> $request->email ?? 'None',
                 'whats_app' => $request->phone,
                 'whats_app_country_code_id' => $request->country,
                 'created_by' =>$user_id
                ]);
        // $user_obj = new $table_name();
        // $user_obj->guard_id = $request->department;
        // $user_obj->role_id = $request->role;
        // $user_obj->name = $request->name;
        // $user_obj->email = $request->email;
        // $user_obj->whatsapp = $request->phone;
        // $user_obj->country_phone_code_id = $request->country;
        // //$user_obj->password = Hash::make($request->password);
        // $user_obj->created_by = $user_id;
        // $user_obj->save();
            
          return response()->json(['success'=>Helper::message_format('Record Saved','success'),'flag'=>true],200);
        
        }else{
            $keys = $validator->errors()->keys();
            $vals  = $validator->errors()->all();
            $errors = array_combine($keys,$vals);
            
            return response()->json(['errors'=>$errors]);
        }
    }

     protected function getGuardTabName($role_id)
     {


             $guard_id=AdminRole::where(['id'=>$role_id])->first()->guard_id;
             $table_name=Helper::user_table($guard_id);
             return $table_name;
     }
       public function check_email($email,$phone)
       {
              if(UserAdmin::where(['email'=> $email])->orWhere(['whatsapp'=>$phone])->exists())
                {
                    //  dd(123);
                   return 'Your Something Already Registered in the Admin Department';
                
                }
              
              if(UserWarehouse::where(['email'=>$email])->orWhere(['whatsapp'=>$phone])->exists())
                {
                    //  dd(123);
                   return 'Your Something Already Registered in the Warehouse Department';
                
                }

                if(UserOperation::where(['email'=>$email])->orWhere(['whatsapp'=>$phone])->exists())
                {
                      
                    return 'Your Something Already Registered in the  Operation Department';
                
                }

                if(UserSale::where(['email'=>$email])->orWhere(['whatsapp'=>$phone])->exists())
                {
                      
                 return 'Your Something Already Registered in the  Sale Department';
                
                }

               if(UserStore::where(['email'=>$email])->orWhere(['whatsapp'=>$phone])->exists())
                {
                      
                   return 'Your Something Already Registered in the  Department';
                
                }
                

       }


  public function viewAll(){
       
       $guard_name=Helper::guard_helper(1);
       $table_name=Helper::user_table(1);
       $user=$table_name::where('status',1)->get();
        return view('admin.amaster.department_user.user_list',compact('user','guard_name'));

    }
    

    public function randomTableView($id){

     $guard_name=Helper::guard_helper($id);
     $table_name=Helper::user_table($id);
     $user=$table_name::all();
     return view('admin.amaster.department_user.user_list',compact('user','guard_name'));

        
    }

    

    protected function randomTableREdit($id,$role_id)
    {
       $table_name=$this->getGuardTabName($role_id);   
       $guard=Guard::all();
       $country_code = CountryCode::all();
       $user_edit=$table_name::where(['id'=>$id])->first();

       $all_role=AdminRole::where(['guard_id'=>$user_edit->guard_id])->get();


       
      return view('admin.amaster.department_user.user_edit',compact('all_role','guard','user_edit','country_code'));
      
    }



protected function update(Request $request)
{

  
      $table_name=$this->getGuardTabName($request->role);
    
      $user_id=$request->user_id;
      $validator = Validator::make($request->all(),[
      'role' => 'required|not_in:0',
      'email' => "required|unique:$table_name,email,$user_id",
      'name' => ['required'],
      'phone' => "required|unique:$table_name,whats_app,$user_id",
      ]);
     
    

      if ($validator->fails()){
            
            return response()->json(["error"=>true,"message"=>$validator->errors()->all()],401);
      }
      else
      {
      
      $record = $table_name::where('id',$request->user_id)->first();
      if($record->email !== $request->email){
        // dd("saab");
        $record->update([
           'email_verify' => 0
        ]);
      }
      $record->update([
        'role_id' => $request->role,
        'email' => $request->email ?? '555@gmail.com',
        'name' => $request->name,
        'whats_app' => $request->phone, 
        'whats_app_country_code_id' => $request->country ?? '',
      ]);
     

      }
   
 
      return response()->json(['success'=>Helper::message_format('Record Updated','success'),'flag'=>true],200);

//       if($table_name::where(['id'=>$request->user_id,'role_id'=>$request->role,'email'=>$request->email,'country_phone_code_id'=>$request->country,'whatsapp'=>$request->phone])->exists())
//       {
//       $table_name::where(['id'=>$request->user_id])->update(['name'=>$request->name]); 
//       return response()->json(['success'=>Helper::message_format('Record Updated','success'), 'flag' =>true],200);
//       }

//       else if(!($table_name::where(['id'=>$request->user_id,'role_id'=>$request->role,'email'=>$request->emai])->exists())) 
//       {


//       // $message = $this->check_email($request->email,$request->phone);

//       // if($message!='')
//       // {
//       // return response()->json(['success'=>Helper::message_format($message,'danger'),'flag'=>true],200);
//       // }



//       $table_name::where(['id'=>$request->user_id])->update(['status'=>0]);

//       $user_id = Auth::guard('admin')->id();
//       $user_obj = new $table_name();
//       $user_obj->guard_id = $request->guard;
//       $user_obj->role_id = $request->role;
//       $user_obj->name = $request->name;
//       $user_obj->email = $request->email;
//       $user_obj->whatsapp = $request->phone;
//       $user_obj->country_phone_code_id = $request->country;
//       //$user_obj->password = Hash::make($request->password);
//       $user_obj->created_by = $user_id;
//       $user_obj->save();
//       return response()->json(['success'=>Helper::message_format('Record Updated','success'),'flag'=>true],200);


// }    

}

   

    protected function send_email_otp(Request $request)
    {          
    $role_id =$request->role_id;
    $email =$request->email;
    $id =$request->id;
  
            $table_name=$this->getGuardTabName($role_id);
            
            if($table_name::where(['id'=>$id,'role_id'=>$role_id,'email'=>$email])->exists())
            {

                    $otp_code=Helper::generateNumericOTP(6);
                    if($this->send_otp($otp_code,$email))
                    {

                       $table_name::where(['id'=>$id,'role_id'=>$role_id,'email'=>$email])->update(['otp_code'=>$otp_code]);
                      return response()->json(['success'=>true,'email'=>$email,'role_id'=>$role_id,'user_id'=>$id]);
                    }

            }
            else
            {
                   return response()->json(['success'=>false]); 
            }
    }

    protected function email_verify(Request $request){
     
        $table_name=$this->getGuardTabName($request->role_id);
            if($table_name::where(['id'=>$request->user_id,'role_id'=>$request->role_id,'email'=>$request->email,'otp_code'=>$request->otp_code])->exists())
            {
                  $department=$table_name::where(['id'=>$request->user_id,'role_id'=>$request->role_id])->first();
                  $securit_pin     = Helper::generateNumericOTP(6);
                 // $department_role = AdminRole::Where(['guard_id'=>$department->guard_id])->pluck('name')->first();
                 $department_name = $department->guardName->name;
            
        if($this->send_welcome_kit_email($securit_pin,$request->email,$department->configAssignRole->name,$department_name))
                {
                
               $department = $table_name::where(['id'=>$request->user_id,'role_id'=>$request->role_id,'email'=>$request->email])->update(['otp_code'=>'','email_verify'=>1,'security_pin'=>$securit_pin]);

                   return response()->json(['success'=>Helper::message_format('Your Email Id Is verified','success'),'res'=>true],200);
                 }
             }
            else
            {
              return response()->json(['success'=>Helper::message_format('Your OTP Incorrect','danger'),'res'=>false],200);
            }    
      
    }


    protected function send_otp($otp_code,$email){
  
          if($otp_code!='')
          {
              Mail::to($email)->send(new OrgLeadEmailCode($otp_code));
              return true;
          }
          else
          {
                return false;
          }

    }

    protected function send_welcome_kit_email($securit_pin,$email,$role,$department)
    {

       //dd($securit_pin,$email,$role,$department);
        
           if($securit_pin!='')
          {
                $data=[
                  'email' => $email,
                   'security_pin' => $securit_pin,
                   'role' => $role,
                   'department' => $department

 
                   ];

              Mail::to($email)->send(new WelcomeKitEmail($data));
              return true;
          }
          else
          {
                return false;
          }       
                    

    }

    protected function department_view($id,$role_id)
    {
              
              $table_name=$this->getGuardTabName($role_id);
            
            if($table_name::where(['id'=>$id,'role_id'=>$role_id])->exists())
            {        
                
               $department=$table_name::where(['id'=>$id,'role_id'=>$role_id])->first();
                
                 

                 if($department->guardName()->exists()){
                     
                     $department_name = $department->guardName->name;
                     $country_code =$department->countryCode->phonecode ?? '';
                     return response()->json(['role_name'=>$department->configAssignRole->name,'department_name'=>$department_name ?? '','name'=>$department->name,'email'=>$department->email ?? '','status'=>$department->status==1?'Active':'In-Active','country_phone_code'=>$country_code ,'whatsapp'=>$department->whats_app ?? '']);
                    }
             }
    }

    public function status($id,$role_id,$status)
       {
               if($status==1)
               {
                 $status=0;
               }
               else
               {
                 $status=1;
               }

             $table_name=$this->getGuardTabName($role_id);
             $table_name::where(['id'=>$id,'role_id'=>$role_id])->update(['status'=>$status]);
         
              return response()->json(['success'=>Helper::message_format('Department User Status Changed','success')],200);

       }

       protected function getPhoneCode($id)
       {
           return response()->json(CountryCode::where(['id'=>$id])->select('phonecode')->first());   

                 
        }

}
