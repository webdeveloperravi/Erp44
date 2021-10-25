<section class="login-block">
	<div class="container">
   <div class="row">
      <div class="col-sm-12">
         <!-- Authentication card start -->
         <form  id="otpForm" onsubmit="event.preventDefault()">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="id" value="<?php echo e($store->id); ?>" id="id">
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
                     <input id="otp_code" type="number" class="form-control" name="otp_code"  placeholder="Enter OTP "    onkeypress="javascript: if(event.keyCode == 13) verifyOTPCode();" autocomplete="off">
                  </div>
                  <div class="row m-t-30">
                     <div class="col-md-4">
                        <button class="btn btn-success btn-md btn-block waves-effect waves-light text-center m-b-20" onclick="verifyOTPCode()">Login</button>
                     </div>
                     <div class="col-md-4">
                        <button class="btn btn-danger btn-md btn-block waves-effect waves-light text-center m-b-20" onclick="resendOtp()">Resend Otp</button>
                     </div>

                     <div class="col-md-4">
                        <button class="btn btn-danger btn-md btn-block waves-effect waves-light text-center m-b-20" onclick="VoiceOtp()"><i class="bi bi-telephone"></i>Voice Call</button>
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
</script>
<script type="text/javascript">
 
   sendSms();

   function sendSms(){
         
      //For Whats App
      var number = "<?php echo e($store->getWhatsAppWithCode($store->id)); ?>";
      var message = "9 Gem Store Login Code "+"<?php echo e($store->otp_code); ?>";
      var url = "https://whatsapp.webtecz.com/wapp/api/send?apikey=971a12bd4c5645ca81b3ed1e753fed11&mobile="+number+"&msg="+message;
       
      $.get(url,function(data){
           console.log(data);
      });

   }
      //For Sms
      
   //     var  body = JSON.stringify(
   //  {   
   //      "messages": [
   //          // {
   //          //     "channel": "whatsapp",
   //          //     "to": "9803462078",
   //          //     "content": "Test WhatsApp Message Text"
   //          // },
   //          {
   //              "channel": "sms",
   //              "to": "<?php echo e($store->getPhoneWithCode($store->id)); ?>",
   //              "content": "9 Gem Store Login Code "+"<?php echo e($store->otp_code); ?>",
   //          }
   //      ]
   //        }
   //      );

   //    $.ajax({
   //       url: "https://platform.clickatell.com/v1/message",
   //       method :"POST",
   //       dataType: 'json',
   //       headers:{
   //          "Authorization" : "qSrGgsZCQYOIf9WTP6He_w==",
   //          "Content-Type" : "application/json"
   //       },
   //       data : body
   //    });     
   
   
   //For Sms
      
   //     var  body = JSON.stringify(
   //  {
   //      "messages": [
   //          // {
   //          //     "channel": "whatsapp",
   //          //     "to": "9803462078",
   //          //     "content": "Test WhatsApp Message Text"
   //          // },
   //          {
   //              "channel": "sms",
   //              "to": "<?php echo e($store->getPhoneWithCode($store->id)); ?>",
   //              "content": "9 Gem Store Login Code "+"<?php echo e($store->otp_code); ?>",
   //          }
   //      ]
   //        }
   //      );

   //    $.ajax({
   //       url: "https://platform.clickatell.com/v1/message",
   //       method :"POST",
   //       dataType: 'json',
   //       headers:{
   //          "Authorization" : "qSrGgsZCQYOIf9WTP6He_w==",
   //          "Content-Type" : "application/json"
   //       },
   //       data : body
   //    });
   //  }


   function resendOtp(){
    let id=$("#id").val();
   $.ajax({
         url : "<?php echo e(route('store.resendOtp')); ?>",
         type : "Post",
         data :{
            _token : "<?php echo e(csrf_token()); ?>",
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
         url : "<?php echo e(route('store.voiceOtp')); ?>",
         type : "Post",
         data :{
            _token : "<?php echo e(csrf_token()); ?>",
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


</script><?php /**PATH E:\newxampp\htdocs\erp2\resources\views/store/auth/otp.blade.php ENDPATH**/ ?>