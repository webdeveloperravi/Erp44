<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
    <title>Inventory </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="#">
    <meta name="keywords" content="Admin , Responsive, Landing, Bootstrap, App, Template, Phone, iOS, Android, apple, creative app">
    <meta name="author" content="#">
 
 <link rel="stylesheet" type="text/css" href="https://colorlib.com//polygon/adminty/files/bower_components/bootstrap/css/bootstrap.min.css">
 <link rel="stylesheet" type="text/css" href="https://colorlib.com//polygon/adminty/files/assets/css/style.css">
</head>

<body>
  
<div id="login">

</div>

<div id="otp">
    
</div>

<script type="text/javascript" src="https://colorlib.com//polygon/adminty/files/bower_components/jquery/js/jquery.min.js"></script>
    <script type="text/javascript" src="https://colorlib.com//polygon/adminty/files/bower_components/popper.js/js/popper.min.js"></script>
    <script type="text/javascript" src="https://colorlib.com//polygon/adminty/files/bower_components/bootstrap/js/bootstrap.min.js"></script>
    <script>
   $(document).ready(function(){
        loginForm();
    }); 

// login form     
   function loginForm(){
    var url ="{{route('store.loginForm')}}";
      $.get(url,function(data){
        $("#login").html(data);
      })
    }
  
                

// verify Login Account
function verifyAccount(){
  hideErrors()
  $(".text-danger").remove(); 
      var email = $("#email").val();
      var url = "{{route('store.verifyAccount')}}";
      $.ajax({

          url : url,
          method : "POST",
         // data : $("#loginForm").serialize(),
         data : $("#loginForm").serialize(),
          success : function(data){
           if(data.errors){
           $.each(data.errors,function(field_name,error){
                        $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
            }); 
          setTimeout(hideErrors,5000); 
          }else if(data.success == false){
               $("#email").after('<span class="text-strong text-danger">'+data.msg+'</span>')
               setTimeout(hideErrors,5000); 
          }
          else{
            $("#login").hide();
            $("#otp").html(data);
          }
       },
      });
}

// function resendOtp(){
//   verifyAccount(); 
// }

function verifyOTPCode(){
  $(".text-danger").remove(); 
      var url = "{{route('store.verifyOTP')}}";
      $.ajax({
          
          url : url,
          method : "POST",
          data : $("#otpForm").serialize(),
         // data :{
         //     "_token": "{{ csrf_token() }}",
         //      "email": email
         // },
          success : function(data){
           if(data.errors){
           $.each(data.errors,function(field_name,error){
                        $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
            }); 
          setTimeout(hideErrors,5000); 
          }
          if(data.success == false){
             
            $("#otp_code").after('<span class="text-strong text-danger">'+data.msg+'</span>')
          } 
          if(data.success){
            // window.location = 'http://www.google.com';
            window.location.href = "{{ route('reauthenticate.index') }}"
          }
       },
      });
}



// Hidden Errors of login account and oto verify
 function hideErrors(){ 
    $(".text-danger").remove(); 
  }




     
 </script>
    </body>
</html>
