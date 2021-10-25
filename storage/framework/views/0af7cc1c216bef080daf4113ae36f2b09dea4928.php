<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Security Pin Verification</title> 
  <link rel="stylesheet" type="text/css" href="https://colorlib.com//polygon/adminty/files/bower_components/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="https://colorlib.com//polygon/adminty/files/assets/css/style.css">
<style>
   .txt-center{
    text-align: center;
}

body{
    height: 100vh;
    font-family: 'Poppins',sans-serif;
    background: url("https://wallpaperplay.com/walls/full/b/3/7/329976.jpg");
    background-repeat: no-repeat;
    background-size: cover;
}

.center1{
    margin: auto;
}

.center3{
    display: flex;
    align-items: center;
    resize: both;
}

.two-step-div .two-title{
    font-size: 22px;
    font-weight: bold;
    color: #3c3c3c;
    margin-top: 15px;
}

.two-step-div .my-img{
    width: 140px;
    height: auto;
}

.two-step-div .two-p{
    font-size: 13px;
    margin-top: 15px;
    margin-bottom: 30px;
    color: #666666;
}

.two-step-div #form{
    direction: ltr;
}

.two-step-div #form input{
    border-color: transparent;
    background: transparent;
    border-bottom: 1.5px solid #cccccc;
    text-align: center;
    font-size: 20px;
    margin-right: 10px;
    margin-left: 10px;
}

.two-step-div #form input:focus{
    outline: 0px transparent !important;
    box-shadow: transparent !important;
    border-right: transparent !important;
    border-left: transparent !important;
    border-top: transparent !important;
    border-color: #00AEEF;
    animation: border-pulsate 1.5s infinite;
    -webkit-tap-highlight-color: transparent;
}

.two-step-div .not-first:disabled{
    background-color: transparent;
    border-bottom: 1px solid #cccccc !important;
}

@-moz-keyframes border-pulsate {
    0% {
        border-color: #00AEEF;
    }
    50% {
        border-color: rgba(0,0,0,0.3);
    }
    100% {
        border-color: #00AEEF;
    }
}
@-webkit-keyframes border-pulsate {
    0% {
        border-color: #00AEEF;
    }
    50% {
        border-color: rgba(0,0,0,0.3);
    }
    100% {
        border-color: #00AEEF;
    }
}
@-o-keyframes border-pulsate {
    0% {
        border-color: #00AEEF;
    }
    50% {
        border-color: rgba(0,0,0,0.3);
    }
    100% {
        border-color: #00AEEF;
    }
}
@keyframes  border-pulsate {
    0% {
        border-color: #00AEEF;
    }
    50% {
        border-color: rgba(0,0,0,0.3);
    }
    100% {
        border-color: #00AEEF;
    }
} 
</style>
</head>
<body>
<!-- partial:index.partial.html -->
<div class="row justify-content-center h-100">
   <div class="col-lg-6 float-right center1 txt-center card-box2 two-step-div align-middle my-auto">
      <img class="my-img" src="https://icons-for-free.com/iconfiles/png/512/locked+login+password+privacy+private+protect+protection+safe-1320196167397530530.png">
      <p class="two-title">Security PIN Verify</p>
      
          <form id="form" method="post" action="<?php echo e(route('reauthenticate.process')); ?>">
           <?php echo csrf_field(); ?> 
           <div class="row justify-content-center" >
            <div class="form-group form-primary">
               <input type="password" class="form-control" id="pin" name="pin" autocomplete="off">
            </div>
            <?php $__errorArgs = ['pin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <span class="text-danger"><?php echo e($message); ?></span>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> 
           </div>
          <button   class="btn btn-primary btn-embossed btn-verify btn-round">Verify</button>
          <?php
              $authUser = auth('store')->user();
          ?>
          <?php if(in_array($authUser->type,$storeUserTypesAll)): ?>
          <button type="button" onclick="sendResetRequest()" class="btn btn-danger  btn-round">Reset Request</button>
          <?php elseif(in_array($authUser->type,$storeTypesAll)): ?>
          <button type="button" onclick="resetSecurityPin(<?php echo e($authUser->id); ?>)" class="btn btn-danger  btn-round">Reset Pin</button>
          <?php endif; ?>
          <a  class="btn btn-inverse text-white btn-round" href="<?php echo e(route('store.logout')); ?>">Logout</a> 
  
      </form>
  </div>
</div>
 
<script type="text/javascript" src="<?php echo e(asset('public/adminty/bower_components/jquery/js/jquery.min.js')); ?>"></script>
<script>
$("#pin").focus();

$(document).ready(function () {

   $('.not-first'). prop("disabled", true);

   $('.btn-verify'). prop("disabled", true);

});   

$(function() {
'use strict';
var body = $('body');

function goToNextInput(e) {
  var key = e.which,
      t = $(e.target),
      sib = t.next('input');

  if (key === 9) {
    return true;
  }

  if (!sib || !sib.length) {
    sib = body.find('input').eq(0);
    $('.btn-verify'). prop("disabled", false);
  }

  sib.select().removeAttr('disabled');
  sib.select().focus();

}

function onFocus(e) {
  $(e.target).select();
}

body.on('keyup', 'input', goToNextInput);
body.on('click', 'input', onFocus);

});


function sendResetRequest(){ 

        if (confirm('Are you sure To Request a new Security Pin Request ? ')) {
           var message = prompt("Please enter any message",'Kindly reset my Security Pin');
        // if (message != null) {
           var url = "<?php echo e(route('securityPinRegenerateRequest.sendRequest')); ?>";
 $.ajax({
   method: 'POST',
   url : url,
   data : {
     _token : "<?php echo e(csrf_token()); ?>",  
     message : message,
   },
   success: function(data){  
        alert(data.msg);
   }
    });
//     }else{
//     alert('Cancelled');
// }
} 
}

function resetSecurityPin(authId){ 

        if (confirm('Are you sure To Reset Security Pin ? ')) {
        //    var message = prompt("Please enter any message"); 
           var url = "<?php echo e(route('securityPinRegenerateRequest.resetDirect')); ?>";
 $.ajax({
   method: 'POST',
   url : url,
   data : {
     _token : "<?php echo e(csrf_token()); ?>",   
     authId : authId,
   },
   success: function(data){ 
        alert('You Recieved a message with new security pin. Thank You');
        location.reload();
   }
    });
   
} 
}

        </script>
 
</body>
</html>
<?php /**PATH E:\newxampp\htdocs\erp2\resources\views/Reauthenticate/index.blade.php ENDPATH**/ ?>