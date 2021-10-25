@extends('layouts.warehouse.app')
@section('content') 
 
<div class="row">
   <div class="col-sm-12">
   <div>
   <div class="content social-timeline">
   <div class="">
   
   <div class="row">
   <div class="col-md-12">
   
   <div class="social-wallpaper">
   <img src="https://colorlib.com/polygon/warehousety/files/assets/images/social/img1.jpg" class="img-fluid width-100" alt="" />
   <div class="profile-hvr">
   <i class="icofont icofont-ui-edit p-r-10"></i>
   <i class="icofont icofont-ui-delete"></i>
   </div>
   </div>
   
   
   {{-- <div class="timeline-btn">
   <a href="#" class="btn btn-primary waves-effect waves-light m-r-10">follows</a>
   <a href="#" class="btn btn-primary waves-effect waves-light">Send Message</a>
   </div> --}}
   
   </div>
   </div>
   
   
   <div class="row">
   <div class="col-xl-3 col-lg-4 col-md-4 col-xs-12">
   
   <div class="social-timeline-left">
   
   <div class="card">
   <div class="social-profile">
   <img class="img-fluid width-100" src="https://colorlib.com/polygon/warehousety/files/assets/images/social/profile.jpg" alt="">
   <div class="profile-hvr m-t-15">
   <i class="icofont icofont-ui-edit p-r-10"></i>
   <i class="icofont icofont-ui-delete"></i>
   </div>
   </div>
 
   </div>
   
 
   
    
   
   </div>
   
   </div>
</div>
<div class="row">
<div class="col-xl-12 col-lg-12 col-md-8 col-xs-12 ">

<div class="card social-tabs">
<ul class="nav nav-tabs md-tabs tab-timeline" role="tablist">
   <li class="nav-item">
      <a class="nav-link active" data-toggle="tab" href="#about" role="tab">About</a>
      <div class="slide"></div>
      </li>
<li class="nav-item">
<a class="nav-link " data-toggle="tab" href="#timeline" role="tab">Addresses</a>
<div class="slide"></div>
</li>
{{-- 
<li class="nav-item">
<a class="nav-link" data-toggle="tab" href="#photos" role="tab">Photos</a>
<div class="slide"></div>
</li>
<li class="nav-item">
<a class="nav-link" data-toggle="tab" href="#friends" role="tab">Friends</a>
<div class="slide"></div>
</li> --}}
</ul>
</div>

<div class="tab-content">

<div class="tab-pane " id="timeline">  
   <div class="row"> 
      <div class="col">
         <button class="btn btn-dark float-right mb-3 mr-2" onclick="createAddress()">Create Address</button>
      </div>
   </div> 
   <div  id="createAddress"> </div>
<div class="" id="all"> </div>
</div>


<div class="tab-pane active" id="about">
<div class="row">
<div class="col-sm-12">
<div class="card">
<div class="card-header">
<h5 class="card-header-text">Basic Information</h5>
 <button  onclick="editBasicInformation()"  class="btn btn-primary waves-effect waves-light f-right">
<i class="icofont icofont-edit"></i>
</button>
</div>
<div class="card-block">
<div id="view-info" class="row">
<div class="col-lg-6 col-md-12">
<form>
<table class="table table-responsive m-b-0">
<tr>
<th class="social-label b-none p-t-0">Full Name
</th>
<td class="social-user-name b-none p-t-0 text-muted">{{ $authUser->name ?? "" }}</td>
</tr>
   
<tr>
<th class="social-label b-none">Admin Role</th>
<td class="social-user-name b-none text-muted">{{ $authUser->role->name ?? "" }}</td>
</tr>   
 </table>
 <table class="table table-responsive m-b-0">
   <tr>
   <th class="social-label b-none p-t-0">Phone</th>
   <td class="social-user-name b-none p-t-0 text-muted">{{ $authUser->getPhoneWithCode($authUser->id) }}</td>
   </tr>
   <tr>
   <th class="social-label b-none">Whats App</th>
   <td class="social-user-name b-none   text-muted">{{ $authUser->getWhatsAppWithCode($authUser->id) }}</td>
   </tr>
   <tr>
   <th class="social-label b-none">Email Address</th>
   <td class="social-user-name b-none text-muted">{{ $authUser->email ?? "" }}</td>
   </tr> 
   </table>
</form>
</div>
</div> 
</div>
</div>
</div> 
<div id="editBasicInformation"></div>
</div>
</div>


<div class="tab-pane" id="photos"> 
</div>


<div class="tab-pane" id="friends"> 
</div>

</div>

</div>
</div>
   </div>
   </div>
   </div>
   </div>
   </div>
@endsection
@section('script')
    
<script>
   all();

   function all(){
      var accountId ='{{ $accountId }}';
    var url = "{{ route('warehouseProfile.getAddresses',['/']) }}/"+accountId; 
    $.get(url,function(data){
       $("#all").html(data);
      });
   }
   
   function createAddress(){
      var accountId ='{{ $accountId }}';
   var  url ="{{route('warehouseProfile.createAddress',['/'])}}/"+accountId;
   $.get(url,function(data){
        $("#createAddress").html(data);
      }); 
   }
   
function saveAddress(){
   
   $.ajax({
       url : "{{ route('warehouseProfile.updateAddress') }}",
       method : "POST",
       data : $("#createForm").serialize(),
        success:function(data){
           if(data.errors){
              $.each(data.errors,function(field_name,error){
                 $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
                      $(document).find('[name='+field_name+']').addClass('input-error');
                     }); 
          setTimeout(hideErrors,5000); 
         }else{
           notify('Address Saved','success');
           all();
           $("#createAddress").html('');
         }
      },
   });
}




function editAddress(id){
   
var url = "{{route('warehouseProfile.editAddress',['/'])}}/"+id;
$.get(url,function(data){
   $("#createAddress").html(data)
   
})
var offset = $("#createAddress").offset();
$('html, body').animate({
   scrollTop: offset.top,
   scrollLeft: offset.left
}, 1000);
}

function updateAddress(){
   
   $.ajax({
      url : "{{ route('warehouseProfile.updateAddress') }}",
      method : "POST",
      data : $("#editForm").serialize(),
      success:function(data){
         if(data.errors){
            $.each(data.errors,function(field_name,error){
               $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
                  $(document).find('[name='+field_name+']').addClass('input-error')
               });
               setTimeout(hideErrors,8000); 
            }else{
               notify('Address Updated','success');
               all();
               $("#createAddress").html('');
            }
         },
      });
      
}

function deleteAddress(id){
   swal({
      title: "Are you sure?",
      text: "Once deleted, you will not be able to recover this Address!",
      icon: "warning",
      buttons: true,
      dangerMode: true,
   })
   .then((willDelete) => {
      if (willDelete) {
         var url = "{{route('warehouseProfile.deleteAddress',['/'])}}/"+id;
         $.get(url,function(data){
            
            if(data.success){
               swal(data.message);
               all();
            }
         });
         swal("Deleted Successfully!", {
            icon: "success",
         });
      } else {
         
   }
});


}

function hideErrors(){ 
   $(".text-danger").remove(); 
   $("input").removeClass('input-error');
   $("select").removeClass('input-error');
}


function editBasicInformation(){
   var url = "{{ route('warehouseProfile.editBasicInformation') }}";
   $.get(url,function(data){
      $("#editBasicInformation").html(data);
   });
}

function updateBasicInformation(){
   var url = "{{ route('warehouseProfile.updateBasicInformation') }}";
 
   $.ajax({
      method: 'POST',
      url : url,
      data: $("#basicInformationForm").serialize(),
      success:function(data){
         if(data.errors){
            $.each(data.errors,function(field_name,error){
               $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
                  $(document).find('[name='+field_name+']').addClass('input-error')
               });
               setTimeout(hideErrors,8000); 
            }else{
               $("#editBasicInformation").html('');
               notify('Basic Information Updated','success');
            }
      }
   });
}

</script>
@endsection