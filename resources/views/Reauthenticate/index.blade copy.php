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
    <section class="login-block">
        <div class="container">
       <div class="row">
          <div class="col-sm-12">
             <!-- Authentication card start -->
             <form method="post" action="{{ route('reauthenticate.process') }}">
                @csrf 
                <div class="text-center">
                   <img src="https://colorlib.com//polygon/adminty/files/assets/images/logo.png" alt="logo.png">
                </div>
                <div class="auth-box card">
                   <div class="card-block">
                      <div class="row m-b-20">
                         <div class="col-md-12">
                            <h3 class="text-center">Enter Pin</h3>
                         </div>
                      </div>
                      <div class="form-group form-primary">
                         <input type="password" class="form-control" id="pin" name="pin" autocomplete="off">
                      </div>
                      @error('pin')
                      <span class="text-danger">{{ $message }}</span>
                      @enderror
                     <div class="row">
                        <div class="col-md-6">
                          <button class="btn btn-success btn-md btn-block waves-effect waves-light text-center m-b-20">Verify</button>
                       </div>
                       <div class="col-md-6">
                          <button type="button" onclick="sendResetRequest()" class="btn btn-danger btn-md btn-block waves-effect waves-light text-center m-b-20">Reset Request</button>
                       </div>
                     </div>
                      <hr/>
                      <div class="row">
                         <div class="col-md-10">
     
                             <a  class="btn btn-inverse btn-sm text-white" href="{{ route('store.logout') }}">Logout</a> 
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

<script type="text/javascript" src="https://colorlib.com//polygon/adminty/files/bower_components/jquery/js/jquery.min.js"></script>
    <script type="text/javascript" src="https://colorlib.com//polygon/adminty/files/bower_components/popper.js/js/popper.min.js"></script>
    <script type="text/javascript" src="https://colorlib.com//polygon/adminty/files/bower_components/bootstrap/js/bootstrap.min.js"></script> 
    <script>
       $("#pin").focus();

       function sendResetRequest(){ 
        


         if (confirm('Are you sure To Request a new Security Pin Request ? ')) {
            var message = prompt("Please enter any message");
         if (message != null) {
            var url = "{{route('securityPinRegenerateRequest.sendRequest')}}";
  $.ajax({
    method: 'POST',
    url : url,
    data : {
      _token : "{{ csrf_token() }}",  
      message : message,
    },
    success: function(data){ 
         alert('Request Send Successfully');
    }
  });
} else {
    alert('Cancelled');
}
         } 
       }

       
    </script>

    </body>
</html>
