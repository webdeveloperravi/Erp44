@php
use App\Helpers\Helper;
$authUser = auth('admin')->user();

$activeModule = App\Model\Admin\Setting\Module::where('route',Route::currentRouteName())->first();
if($activeModule){
   $activeModuleParents = $activeModule->getAllParents()->toArray();               
}else{
   $activeModuleParents= [0];
} 
@endphp 
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
<meta http-equiv="X-UA-Compatible" content="IE=edge" /> 

   <title>{{ adminPageTitle() }}</title>
   <link rel="icon" href="{{asset('public/adminty/assets/images/404/favicon.ico')}}" type="image/x-icon">
   <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
   
   <link rel="stylesheet" type="text/css" href="{{ asset('public/adminty/bower_components/bootstrap/css/bootstrap.min.css')}}">
   <link rel="stylesheet" type="text/css" href="{{ asset('public/adminty/assets/icon/themify-icons/themify-icons.css')}}">
   <link rel="stylesheet" type="text/css" href="{{ asset('public/adminty/assets/icon/icofont/css/icofont.css')}}">
   <link rel="stylesheet" type="text/css" href="{{ asset('public/adminty/assets/icon/feather/css/feather.css')}}">
   <link rel="stylesheet" type="text/css" href="{{ asset('public/adminty/assets/css/style.css')}}">
   <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
   <link rel="stylesheet" type="text/css" href="{{ asset('public/adminty/assets/css/jquery.mCustomScrollbar.css')}}">
   <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"> 
   <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
   <link rel="stylesheet" href="{{ asset('public/adminty/assets/pages/social-timeline/timeline.css') }}"> 
   <link rel="stylesheet" type="text/css" href="{{ asset('public/adminty/assets/pages/timeline/style.css') }}">

   {{-- Js-Snackbar --}}
   {{-- <link rel="stylesheet" href="{{ asset('public/adminty/js-snackbar/js-snackbar.css') }}">   --}}
   {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css"> --}}

   {{-- Pnotify --}}
   {{-- <link rel="stylesheet" type="text/css" href="{{ asset('public/adminty/bower_components/pnotify/css/pnotify.css') }}">
   <link rel="stylesheet" type="text/css" href="{{ asset('public/adminty/bower_components/pnotify/css/pnotify.brighttheme.css') }}">
   <link rel="stylesheet" type="text/css" href="{{ asset('public/adminty/bower_components/pnotify/css/pnotify.buttons.css') }}">
   <link rel="stylesheet" type="text/css" href="{{ asset('public/adminty/bower_components/pnotify/css/pnotify.history.css') }}">
   <link rel="stylesheet" type="text/css" href="{{ asset('public/adminty/bower_components/pnotify/css/pnotify.mobile.css') }}"> --}}

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

   {{-- Datatable Buttons --}}
   <link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet" />
   <link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet" />

   {{-- SweetAlert --}}
   <link rel="stylesheet" type="text/css" href="{{ asset('public/adminty/bower_components/sweetalert/css/sweetalert.css') }}">
   <style>  
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
  .input-error {
     border: 1px solid red;
  }

  @media screen and (min-width: 768px) {
     ..modal {
        overflow-y: auto;
       /* width:900px !important; */;
     }

     .modal-lg {
        /* width:900px; */
        overflow-y: auto;
     }

     .md-modal {
        max-width: 930px !important;
        overflow-y: auto;
     }
  }

  th {
     font-weight: 600 !important;
  }

  td {
     font-weight: 600 !important;
  }

  .select2-container--default .select2-selection--single .select2-selection__rendered {
           /* color: white; */
     line-height: 1.25;
     background-color: white;
  }

  .select2-container--default .select2-selection--single .select2-selection__arrow {
           /* color: white; */
           /* top: 10px; */;
  }

  .select2-container .select2-selection--single {
     height: auto !important;
  }

  .alert {
     margin-bottom: 4px;
  }

  .input-border-red {
     border: 1px solid red;
  }

  .tooltip-content5 {
     overflow: visible !important;
     /* width: auto; */
     word-wrap: break-word;
  }

  .header-navbar .navbar-wrapper .navbar-container .header-notification .profile-notification {
     width: auto;
  }

  tfoot input {
      width: 100% !important;
      padding: 3px !important;
      box-sizing: border-box !important;
  },
  a:focus, a:hover{
     color:white !important;
  },
  .vgt-left-align sortable{
     font-weight: 500 !important;
  }
  th,td{
     text-align:left !important;
  }
  /* custom scrollbar */
  body::-webkit-scrollbar {
  width: 20px;
  }

  body::-webkit-scrollbar-track {
  background-color: transparent;
  }

  body::-webkit-scrollbar-thumb {
  background-color: #d6dee1;
  border-radius: 20px;
  border: 6px solid transparent;
  background-clip: content-box;
  } 
  </style>
   @yield('css')  
</head>
<body>
  <div class="md-overlay"></div>
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
  <div id="pcoded" class="pcoded iscollapsed" nav-type="st6" theme-layout="vertical" vertical-placement="left" vertical-layout="wide" pcoded-device-type="desktop" vertical-nav-type="expanded" vertical-effect="shrink" vnavigation-view="view1" fream-type="theme1" sidebar-img="false" sidebar-img-type="img1" layout-type="light">
     <div class="pcoded-overlay-box"></div>
     <div class="pcoded-container navbar-wrapper">
        <nav class="navbar header-navbar pcoded-header iscollapsed" header-theme="theme1" pcoded-header-position="fixed">
           <div class="navbar-wrapper">
              <div class="navbar-logo" logo-theme="theme1">
                 <a class="mobile-menu" id="mobile-collapse" href="#!">
                 <i class="feather icon-menu icon-toggle-right"></i>
                 </a>
                 <a href="index.html">
                    <h3>Admin</h3>
                    {{-- <img class="img-fluid" src="../files/assets/images/logo.png" alt="Theme-Logo"> --}}
                 </a>
                 <a class="mobile-options">
                 <i class="feather icon-more-horizontal"></i>
                 </a>
              </div>
              <div class="navbar-container container-fluid">
                 <ul class="nav-left">
                    <li class="header-search">
                       <div class="main-search morphsearch-search">
                          <div class="input-group">
                             <span class="input-group-addon search-close"><i class="feather icon-x"></i></span>
                             <input type="text" class="form-control">
                             <span class="input-group-addon search-btn"><i class="feather icon-search"></i></span>
                          </div>
                       </div>
                    </li>
                    <li>
                       <a href="#!" onclick="javascript:toggleFullScreen()">
                       <i class="feather icon-maximize full-screen"></i>
                       </a>
                    </li>
                 </ul>
                 <ul class="nav-right">
                    <li class="user-profile header-notification">
                       <div class="dropdown-primary dropdown">
                          <div class="dropdown-toggle" data-toggle="dropdown">
                             <img src="https://colorlib.com//polygon/adminty/files/assets/images/avatar-4.jpg" class="img-radius" alt="User-Profile-Image">
                             <span>{{ $authUser->name ?? '' }}  ({{ $authUser->role->name ?? "" }}) </span> 
                             <i class="feather icon-chevron-down"></i>
                          </div>
                          <ul class="show-notification profile-notification dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                              <li>
                                <a href="{{route('adminProfile')}}">
                                <i class="feather icon-user"></i> Profile
                                </a>
                             </li> 
                            <li>
                                <a href="#">
                                </i>N : {{ $authUser->name ?? ""}}
                                </a>
                             </li>  
                             <li>
                                <a href="#">
                                Role : {{ $authUser->role->name ?? ""}}
                                </a>
                             </li>    
                             <li>
                                <a class="dropdown-item" href="{{ route('admin.logout') }}">
                                   {{ __('Logout') }}</a>
                           
                             </li>
                          </ul>
                       </div>
                    </li>
                 </ul>
              </div>
           </div>
        </nav> 
         <div class="pcoded-main-container" style="margin-top: 56px;">
            <div class="pcoded-wrapper">
               <nav class="pcoded-navbar" navbar-theme="theme1" active-item-theme="theme1" sub-item-theme="theme2" active-item-style="style0" pcoded-navbar-position="fixed">
                  <div class="pcoded-inner-navbar main-menu">
                     <ul class="pcoded-item pcoded-left-item">
                        @php   
                           if(Session::has('myModulesAdmin') && Session::has('modulesAdmin')){
                              $myModules = Session::get('myModulesAdmin'); 
                              $modules = Session::get('modulesAdmin'); 
                              
                           }else{
                              // $myModules = $authUser->role->modules->pluck('id')->toArray(); 
                              // $modules = App\Model\Admin\Setting\Module::find($myModules);  
                           }    
                       
                        @endphp
                        @foreach($modules as $module)
                        @if($module->route !== null  && in_array($module->id,$myModules)) 
                        @elseif($module->route == null && $module->parent == 0 && in_array($module->id,$myModules)) 
                        <li class="pcoded-hasmenu  pcoded-trigger"> 
                           <a href="javascript:void(0)">
                           <span class="pcoded-micon"><i class="feather icon-box"></i></span>
                           <span class="pcoded-mtext">{{ $module->title }}</span>
                           </a> 
                           @includeWhen(count($module->sub_module) > 0,'layouts.admin.submodule',['modules' =>$module->sub_module,'myModules'=> $myModules,'activeModuleParents'=> $activeModuleParents])
                        </li>
                        @endif 
                        @endforeach
                     </ul>
                  </div>
               </nav>
               <div class="pcoded-content">
                  <div class="pcoded-inner-content">
                     <div class="main-body"> 
                        @yield('content') 
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

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
  
//Custom Functions 
// $(document).ready(function(){  
//   $("#clickNow").trigger('click');
// });


function clearValue(event){
  val = event.target.value;
  if(val == 0 ){
    event.target.value="";
  } 
}

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
});



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
  hideErrors();
  // $(".pcoded-content").LoadingOverlay("show");
  //  $.LoadingOverlay("show");
});
$(document).ajaxStop(function(){
  //  $.LoadingOverlay("hide");
  // $(".pcoded-content").LoadingOverlay("hide");
}); 


function hideErrors(){ 
  $(".text-danger").remove(); 
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
 
var url = window.location;
 $('li.pcoded-hasmenu a').filter(function() {
   //  console.log(this); 
	 return this.href == url;
}).parent('li').addClass('active');

 $('li.pcoded-hasmenu a').filter(function() {
	 return this.href == url;
}).parent('li').parent('ul').parent('li.  00 ').addClass('pcoded-trigger');


</script>
@yield('script')  
</body>
</html>