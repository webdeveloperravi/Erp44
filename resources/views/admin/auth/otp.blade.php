<section class="login-block">
	<div class="container">
   <div class="row">
      <div class="col-sm-12">
         <!-- Authentication card start -->
         <form  id="otpForm" onsubmit="event.preventDefault()">
            @csrf
            <input type="hidden" name="id" value="{{$user->id}}" id="id">
            <div class="text-center">
               <img src="https://colorlib.com//polygon/adminty/files/assets/images/logo.png" alt="logo.png">
            </div>
            <div class="auth-box card">
               <div class="card-block">
                  <div class="row m-b-20">
                     <div class="col-md-12">
                        <h3 class="text-center">Enter OTP</h3>
                     </div>
                  </div>
                  <div class="form-group form-primary">
                     <input id="otp_code" type="number" class="form-control" name="otp_code" placeholder="Enter OTP "  autocomplete="off">
                  </div>
                  <div class="row m-t-30">
                     <div class="col-md-4">
                        <button class="btn btn-success btn-md btn-block waves-effect waves-light text-center m-b-20" onclick="verifyOTPCode()">Login</button>
                     </div>
                     <div class="col-md-4">
                        <button class="btn btn-danger btn-md btn-block waves-effect waves-light text-center m-b-20" onclick="resendOtp()">Resend Otp</button>
                     </div> 
                      <div class="col-md-4">
                        <button class="btn btn-danger btn-md btn-block waves-effect waves-light text-center m-b-20" onclick="VoiceOtp()">Voice Call</button>
                     </div>
                  </div>
                  <hr/>
                  <div class="row">
                     <div class="col-md-10">
                        <p class="text-inverse text-left m-b-0">Thank you.</p>
                        <p class="text-inverse text-left"> </p>
                     </div>
                     <div class="col-md-2">
                        <img src="https://colorlib.com//polygon/adminty/files/assets/images/auth/Logo-small-bottom.png" alt="small-logo.png">
                     </div>
                  </div>
               </div>
            </div>
         </form>
         <!-- end of form -->
      </div>
      <!-- end of col-sm-12 -->
   </div>
</div>
</section>
<script>
   $(Document).ready(function(){
         $("#otp_code").focus();
   });
  
  function resendOtp(){
    let id=$("#id").val();
   $.ajax({
         url : "{{ route('admin.resendOtp') }}",
         type : "Post",
         data :{
            _token : "{{csrf_token()}}",
            id : id 
         },
         success:function(data){
           
          if(data.success){  
           console.log(data);
            
          }
          if(data.errors){
         
          }
          },
        });
 }
 
 function VoiceOtp(){
    let id=$("#id").val();
   $.ajax({
         url : "{{ route('admin.voiceOtp') }}",
         type : "Post",
         data :{
            _token : "{{csrf_token()}}",
            id : id 
         },
         success:function(data){
           
          if(data.success){  
           console.log(data);
            
          }
          if(data.errors){
         
          }
          },
        });
 }
     


  


   </script>
