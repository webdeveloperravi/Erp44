@php
use App\Helpers\Helper;
use App\Model\Admin\Setting\ConfigurationRole;
  $guard_id=Session::get('guard_id');
  $sidebar_guard= Helper::getGuardRoutes($guard_id);
  $guard_name=Helper::guardName($guard_id); 
@endphp 
 
<!DOCTYPE html>
<html lang="en">
 
<head>
   <meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="description" content="#">
<meta name="keywords" content="Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
<meta name="author" content="#">
    {{-- <title>{{ Helper::getStoreName() }}-{{ Route::currentRouteName() }}  </title> --}}
    <link rel="icon" href="https://colorlib.com/polygon/adminty/files/assets/images/favicon.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
    
    <link rel="stylesheet" type="text/css" href="{{ asset('public/adminty/bower_components/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="https://colorlib.com//polygon/adminty/files/assets/icon/themify-icons/themify-icons.css">
    <link rel="stylesheet" type="text/css" href="https://colorlib.com//polygon/adminty/files/assets/icon/icofont/css/icofont.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/adminty/assets/icon/feather/css/feather.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/adminty/assets/css/style.css')}}">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/adminty/assets/css/jquery.mCustomScrollbar.css')}}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"> 
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('public/adminty/assets/pages/social-timeline/timeline.css') }}"> 
    {{-- Js-Snackbar --}}
    <link rel="stylesheet" href="{{ asset('public/adminty/js-snackbar/js-snackbar.css') }}">  
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    {{-- Pnotify --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('public/adminty/bower_components/pnotify/css/pnotify.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/adminty/bower_components/pnotify/css/pnotify.brighttheme.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/adminty/bower_components/pnotify/css/pnotify.buttons.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/adminty/bower_components/pnotify/css/pnotify.history.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/adminty/bower_components/pnotify/css/pnotify.mobile.css') }}">

    {{-- LightBox --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('public/adminty/bower_components/lightbox2/css/lightbox.min.css') }}"> 
    <link rel="stylesheet" type="text/css" href="{{ asset('public/adminty/assets/pages/pnotify/notify.css') }}">

    {{-- JS-Forms --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('public/adminty/assets/pages/j-pro/css/demo.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/adminty/assets/pages/j-pro/css/font-awesome.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/adminty/assets/pages/j-pro/css/j-forms.css')}}">

        {{-- Select 2 --}}
        <link rel="stylesheet" href="{{ asset('public/adminty/bower_components/select2/css/select2.min.css') }}"/> 
        <link rel="stylesheet" href="{{ asset('public/adminty/bower_components/bootstrap-multiselect/css/bootstrap-multiselect.css') }}"/>
        <link rel="stylesheet" href="{{ asset('public/adminty/bower_components/multiselect/css/multi-select.css') }}"/>
        
    {{-- Notification --}} 
    <link rel="stylesheet" type="text/css" href="{{ asset('public/adminty/assets/pages/notification/notification.css') }}">
    <link rel="stylesheet" href="{{ asset('public/adminty/app.css') }}"> 
    <link rel="stylesheet" href="{{ asset('public/css/app.css') }}">


    
    <style> 
    .intl-tel-input {
    display: table-cell;
    }
    .intl-tel-input .selected-flag {
    z-index: 4;
    }
    .intl-tel-input .country-list {
    z-index: 5;
    }
    .input-group .intl-tel-input .form-control {
    border-top-left-radius: 4px;
    border-top-right-radius: 0;
    border-bottom-left-radius: 4px;
    border-bottom-right-radius: 0;
    }

   .input-error{
         border:1px solid red;
   }
   @media screen and (min-width: 768px) {
      ..modal {
  overflow-y:auto;
  /* width:900px !important; */
}

  .modal-lg{
      /* width:900px; */
      overflow-y: auto;
  }

  .md-modal{
   max-width: 930px !important;
   overflow-y: auto;
  }
} 
      th{
         font-weight: 600 !important;
      }
      td{
         font-weight: 600 !important;
      }
      .select2-container--default .select2-selection--single .select2-selection__rendered{
         /* color: white; */
         line-height: 1.25;
         background-color: white
      }
      .select2-container--default .select2-selection--single .select2-selection__arrow{
         /* color: white; */
         /* top: 10px; */
      }
      .select2-container .select2-selection--single{
         height:auto !important;
      }
      .alert{
     margin-bottom: 4px;  
    } 
    .input-border-red{
       border: 1px solid red;
    }
    .tooltip-content5{
    overflow: visible !important;
    /* width: auto; */
    word-wrap: break-word;
  }
   
  
  .header-navbar .navbar-wrapper .navbar-container .header-notification .profile-notification{
     width : auto;
  }
   </style>
    @yield('css')  
</head>
<body> 
     
  <div class="theme-loader">
    <div class="ball-scale">
       <div class='contain'>
          <div class="ring">
             <div class="frame"></div>
          </div>
          <div class="ring">
             <div class="frame"></div>
          </div>
          <div class="ring">
             <div class="frame"></div>
          </div>
          <div class="ring">
             <div class="frame"></div>
          </div>
          <div class="ring">
             <div class="frame"></div>
          </div>
          <div class="ring">
             <div class="frame"></div>
          </div>
          <div class="ring">
             <div class="frame"></div>
          </div>
          <div class="ring">
             <div class="frame"></div>
          </div>
          <div class="ring">
             <div class="frame"></div>
          </div>
          <div class="ring">
             <div class="frame"></div>
          </div>
       </div>
    </div>
 </div>
 <!-- Pre-loader end -->
   

@yield('content')
{{-- Main --}}
<script type="text/javascript" src="{{ asset('public/adminty/bower_components/jquery/js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/adminty/bower_components/jquery-ui/js/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/adminty/bower_components/popper.js/js/popper.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/adminty/bower_components/bootstrap/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/adminty/bower_components/jquery-slimscroll/js/jquery.slimscroll.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/adminty/bower_components/modernizr/js/modernizr.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/adminty/bower_components/modernizr/js/css-scrollbars.js') }}"></script> 
<script type="text/javascript" src="{{ asset('public/adminty/bower_components/chart.js/js/Chart.js') }}"></script>
<script src="{{ asset('public/adminty/markerclusterer.js') }}"></script>
<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=true"></script>
<script type="text/javascript" src="{{ asset('public/adminty/assets/pages/google-maps/gmaps.js') }}"></script>
<script src="{{ asset('public/adminty/assets/pages/widget/gauge/gauge.min.js') }}"></script>

{{-- Am Charts   --}}
<script src="{{ asset('public/adminty/assets/pages/widget/amchart/amcharts.js') }}"></script>
<script src="{{ asset('public/adminty/assets/pages/widget/amchart/serial.js') }}"></script>
<script src="{{ asset('public/adminty/assets/pages/widget/amchart/gauge.js') }}"></script>
<script src="{{ asset('public/adminty/assets/pages/widget/amchart/pie.js') }}"></script>
<script src="{{ asset('public/adminty/assets/pages/widget/amchart/light.js') }}"></script>

{{-- Pcoded  --}}
<script src="{{ asset('public/adminty/assets/js/pcoded.min.js') }}"></script>
<script src="{{ asset('public/adminty/assets/js/vartical-layout.min.js') }}"></script>
<script src="{{ asset('public/adminty/assets/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/adminty/assets/pages/dashboard/crm-dashboard.min.js') }}"></script>

 {{-- Social --}}
<script type="text/javascript" src="{{ asset('public/adminty/assets/pages/social-timeline/social.js')}}"></script>

 {{-- Js Snackbar --}}
<script type="text/javascript" src="{{ asset('public/adminty/js-snackbar/js-snackbar.js')}}"></script>  

 {{-- Custom Js --}}
<script type="text/javascript" src="{{ asset('public/adminty/assets/js/script.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/js/app.js') }}"></script> 

 
<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> 

{{-- LightBox --}} 
<script type="text/javascript" src="{{ asset('public/adminty/bower_components/lightbox2/js/lightbox.min.js') }}"></script>
 {{-- P Notify --}}
<script type="text/javascript" src="{{ asset('public/adminty/bower_components/pnotify/js/pnotify.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/adminty/bower_components/pnotify/js/pnotify.desktop.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/adminty/bower_components/pnotify/js/pnotify.buttons.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/adminty/bower_components/pnotify/js/pnotify.confirm.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/adminty/bower_components/pnotify/js/pnotify.callbacks.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/adminty/bower_components/pnotify/js/pnotify.animate.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/adminty/bower_components/pnotify/js/pnotify.history.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/adminty/bower_components/pnotify/js/pnotify.mobile.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/adminty/bower_components/pnotify/js/pnotify.nonblock.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/adminty/assets/pages/pnotify/notify.js') }}"></script>

 {{-- Notification --}}
<script type="text/javascript" src="{{ asset('public/adminty/assets/js/bootstrap-growl.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/adminty/assets/pages/notification/notification.js') }}"></script>

{{-- Select 2 --}}
<script type="text/javascript" src="https://colorlib.com//polygon/adminty/files/bower_components/select2/js/select2.full.min.js"></script>
<script type="text/javascript" src="https://colorlib.com//polygon/adminty/files/bower_components/bootstrap-multiselect/js/bootstrap-multiselect.js"></script>
<script type="text/javascript" src="https://colorlib.com//polygon/adminty/files/bower_components/multiselect/js/jquery.multi-select.js"></script>
<script type="text/javascript" src="https://colorlib.com//polygon/adminty/files/assets/js/jquery.quicksearch.js"></script>
<script type="text/javascript" src="https://colorlib.com//polygon/adminty/files/assets/pages/advance-elements/select2-custom.js"></script>
<script type="text/javascript" src="{{ asset('public/adminty/assets/js/modal.js')}}"></script>
 {{-- Custom Js --}}
<script src="{{ asset('public/admin/js/own.js') }}"></script>  

<script>
//Theme Functions
window.dataLayer = window.dataLayer || [];
function gtag(){
  dataLayer.push(arguments);
}

gtag('js',new Date());
gtag('config','UA-23581568-13');

// Security Pin Start
$(document).ready(function(){
//   getSecurityStatus();
  $("#clickNow").trigger('click');
});
 

//Warehouse User Inactivity required Security Pin
var idleTime = 0;
$(document).ready(function (){
  //Increment the idle time counter every minute.
  var idleInterval = setInterval(timerIncrement, 60000); // 1 minute

  //Zero the idle timer on mouse movement.
  $(this).mousemove(function (e) {
      idleTime = 0;
  });
  $(this).keypress(function (e) {
      idleTime = 0;
  });
});

function timerIncrement(){
  idleTime = idleTime + 1;
  if (idleTime > 10) { // 20 minutes
    // getSecurityPinModal(); 
    setSecurityStatus(1);
    idleTime = 0;
  }
}

// function securityPinSubmit(){
 
//   var security_pin = $("#pin").val();
//   var token = '{{ csrf_token() }}';
    
//   $.ajax({
//     url: "{{ route('admin.security.pin') }}",
//     type: "POST",
//     data:{
//         _token: token,
//         security_pin: security_pin
//     },
//     success:function(data){
//         if(data == true){ 
//             $("#securityPinModal").removeClass('md-show');
//             $('#securityPinModal').modal('hide');
//             $("#pin").val("");
            
//         }else{
//             alert("Wrong Code");
//         }
//     },
//   });
// }

// function setSecurityStatus(status){
//   var status = status;
//   var url = "{{ route('admin.set.security.status',['/']) }}/"+status;
//   $.get(url,function(data){
//       if(data == true){
//         getSecurityStatus();
          
//       }else{
//          return  false;
//       }
//   });
// }

// function getSecurityStatus(){
  
//   var url = "{{ route('admin.get.security.status') }}";
//   $.get(url,function(data){
//      if(data == 1){
//         $("#securityPinModal").addClass('md-show');
//         $("#pin").focus();
//         $('#securityPinModal').modal({
//            backdrop: 'static',
//            keyboard: false
//            });
//       }else{
//          return  false;
//       }
//   });
// }
// Security Pin End

//Custom Functions

function clearValue(event){
  val = event.target.value;
  if(val == 0 ){
    event.target.value="";
  } 
}

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
});

function hideErrors(){ 
  $(".text-danger").remove(); 
}



//P Notify
function notify(message, type){
 $.growl({
     message: message
 },{
     type: type,
     allow_dismiss: false,
     label: 'Cancel',
     className: 'btn-xs btn-inverse',
     placement: {
         from: 'top',
         align: 'right'
     },
     delay: 2500,
     animate: {
             enter: 'animated fadeInRight',
             exit: 'animated fadeOutRight'
     },
     offset: {
         x: 30,
         y: 30
     }
 });
}

// Loading Overlay

$.LoadingOverlaySetup({
   background      : "rgba(255,255,255,0.8)",
   image           : "{{ asset('/public/loader.svg') }}",
  //  image           : "",
  //  imageAnimation  : "1.5s fadein",
   imageColor      : "#2dcee3",
  //  fontawesome : "fa fa-refresh fa-spin"
});

$(document).ajaxStart(function(){
   // hideErrors();
  $(".pcoded-content").LoadingOverlay("show");
  //  $.LoadingOverlay("show");
});
$(document).ajaxStop(function(){
  //  $.LoadingOverlay("hide");
  $(".pcoded-content").LoadingOverlay("hide");
});


 //SMS Api
// function hellohspa(){
//   var xhr = new XMLHttpRequest(),
//   body = JSON.stringify(
//   {
//     "messages": [
//       {
//           "channel": "whatsapp",
//           "to": "9803462078",
//           "content": "Test WhatsApp Message Text"
//       },
//       {
//           "channel": "sms",
//           "to": "9803462078",
//           "content": "Test SMS Message Text"
//       }
//     ]
//   }
//   );
//   xhr.open('POST', 'https://platform.clickatell.com/v1/message', true);
//   xhr.setRequestHeader('Content-Type', 'application/json');
//   xhr.setRequestHeader('Authorization', 'l-syDMuMT-OOhOFQ8IYCjg==');
//   xhr.onreadystatechange = function(){
//       if (xhr.readyState == 4 && xhr.status ==  200) {
//           console.log('success');
//       }
//   };
//   xhr.send(body);
// }

function hideErrors(){ 
  $(".text-danger").remove(); 
//   $(".input-error").remove(); 
  $('input').removeClass('input-error');

}
 
</script>


<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script> 
<script>
   //  window.$('#table_id').DataTable();
   $(document).ready(function() {
   // Setup - add a text input to each footer cell
   $('#table_id tfoot th').each( function () {
       var title = $(this).text();
       $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
   } );

   // DataTable
   var table = $('#table_id').DataTable({
       initComplete: function () {
           // Apply the search
           this.api().columns().every( function () {
               var that = this;

               $( 'input', this.footer() ).on( 'keyup change clear', function () {
                   if ( that.search() !== this.value ) {
                       that
                           .search( this.value )
                           .draw();
                   }
               } );
           } );
       }
   });

} );

function closeModal(){ 
   $(".modal-backdrop").remove(); 
   
   $('#Modal-overflow').modal('hide');
} 

</script>
@yield('script')  
</body>
</html>