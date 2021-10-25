<section class="login-block">
   <!-- Container-fluid starts -->
   <div class="container">
    <div class="row">
         <div class="col-sm-12">
            <!-- Authentication card start -->
            <form  id="loginForm" onsubmit="event.preventDefault(0)">
               <?php echo csrf_field(); ?>
               <div class="text-center">
                  <img src="https://colorlib.com//polygon/adminty/files/assets/images/logo.png" alt="logo.png">
               </div>
               <div class="auth-box card">
                  <div class="card-block">
                     <div class="row m-b-20">
                        <div class="col-md-12">
                       <h3 class="text-center">Store Login</h3>
                        </div>
                     </div>
                     <div class="form-group form-primary">
                        <input id="email" type="text" class="form-control<?php echo e($errors->has('email') ? ' is-invalid' : ''); ?> mb-2" name="email"  placeholder="Email or Phone" autocomplete="off"
                         onkeypress="javascript: if(event.keyCode == 13) verifyAccount();"
                         >
                        
                     </div>
                     <div class="row m-t-30">
                        <div class="col-md-12">
                           <button type="button" id="sendOtpButtton" class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20"  onclick="verifyAccount()">Send OTP</button>
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
      <!-- end of row -->
   </div>
   <!-- end of container-fluid -->
</section> 
<script>
$(Document).ready(function(){
      $("#email").focus();
});
</script><?php /**PATH E:\newxampp\htdocs\erp2\resources\views/store/auth/login.blade.php ENDPATH**/ ?>