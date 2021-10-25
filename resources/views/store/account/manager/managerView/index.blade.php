@extends('layouts.store.app')
@section('css')
 <style>
  th {
  text-align: left !important;
}
</style>
@endsection
@section('content')
<div class="row">
<div class="col">
  <a href="{{route('managerAccount.index')}}" class="btn btn-inverse btn-sm  m-2">Back</a>
</div>
</div>  
<div id="verifyAccount"> </div>
<div id="edit"> </div>
<div id="main">
<div class="card">
    <!--Header ---->
    <div class="card-footer p-0" style="background-color: #04a9f5">
      <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">{{$managerAccount->name ?? ''}}</h5>
     </div>
    
    <div class="card-body"> 
    <div class="row">

    <div class="col col-md-6">

    <div class="row">
      
      <div class="col col-md-3">
      <img src="{{ asset('public/images/lead-images/abc.jpg') }}" alt="" class="img-fluid img-thumbnail" width="100">
      </div>

      <div class="col-md-9">
      <h6><span>{{$managerAccount->name ?? ''}}</span></h6>
      <h6><span>{{$managerAccount->managerRole->name ?? ''}}</span></h6>
      <h6><span>{{$managerAccount->email ?? ''}}</span></h6>
      <h6><span>+{{$managerAccount->getPhoneWithCode($managerAccount->id)?? ''}}</span></h6>
      </div>

     </div>
    </div>
    <!---Left Div---->
    <div class="col col-lg-6 col-md-6">
      <div class="row">
     <div class="col mb-2">
      @if($managerAccount->email_verify == 1 && $managerAccount->phone_verify==1)
      <button   class="btn btn-sm btn-success f-right"><i class="fa fa-check text-white"></i>Verified Account</button>
      @else
      <button class="btn btn-danger btn-sm f-right m-r-2" onclick="verifyAccount('{{$managerAccount->id}}')">Verify Now</button>
    
       @endif 
    </div> 
 
    </div><!----Close Left div Row -->
  </div> <!---Left Div close-->
 </div>
  <ul class="nav nav-tabs m-2" role="tablist" >
    <li class="nav-item">
      <a class="nav-link active" data-toggle="tab" href="#nav_details"  onclick="detail()">Details</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#nav_address" onclick="managerAccountIndex()">Address</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#nav_comment" onclick="commentIndex()">Comments</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#nav_image" onclick="imageIndex()">Images</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#nav_zone" onclick="zoneAttachIndex()">Zones</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#nav_ip" onclick="ipAttachIndex()">IP Attach</a>
    </li>
  </ul>

 
  <div class="tab-content">
    <div id="nav_details" class="container tab-pane active"><br>
    <div id="detail">
    

    </div>
</div>
    <div id="nav_address" class="container tab-pane fade"><br>
      <div id="address"> </div> 
    

    </div>

    <div id="nav_comment" class="container tab-pane fade"><br>
    <div id="comment">

    </div>
    </div>
    <div id="nav_image" class="container tab-pane fade"><br>
      <div id="image">
        
      </div>
    </div>
    <div id="nav_zone" class="container tab-pane fade"><br>
      <div id="zoneView">
         
      </div>
    </div>
    <div id="nav_ip" class="container tab-pane fade"><br>
      <div id="ipView">
         
      </div>
    </div>

  </div>
</div><!---card Body Div close-->
</div><!--Card Div Close-->
</div><!---Main Div Close-->
<!---Sub Store Index --->

  
@endsection
@section('script')
<script>
 detail();
function detail(){

	var url = "{{route('manager.view.view',['/'])}}/"+"{{$managerAccount->id}}";
	$.get(url,function(data){
		$("#detail").html(data);
	})
}

// Manager Account function
  function verifyAccount(accountId)
{
    var url = "{{route('manager.view.verify.view',['/'])}}/"+accountId;
    $.get(url,function(data){

        $("#verifyAccount").html(data);
    })
     var offset = $("#verifyAccount").offset();
         $('html, body').animate({
            scrollTop: offset.top,
            scrollLeft: offset.left
         }, 1000);

     
}

function edit(accountId){

var  url ="{{route('manager.view.edit',['/'])}}/"+accountId;
    $.get(url,function(data){

        $("#edit").html(data);
    })
     var offset = $("#edit").offset();
         $('html, body').animate({
            scrollTop: offset.top,
            scrollLeft: offset.left
         }, 1000);

}

 function managerAccountIndex()
{   
   var storeId = "{{ $managerAccount->id ?? "" }}";
   var  url ="{{route('managerAccount.address.index',['/'])}}/"+storeId; 
   $.get(url,function(data){
      $("#address").html(data);
   }); 
}

function commentIndex(){

 var managerId = "{{ $managerAccount->id ?? "" }}";
   var  url ="{{route('manager.comment.index',['/'])}}/"+managerId; 
   $.get(url,function(data){
      $("#comment").html(data);
   }); 

}

function imageIndex(){
 var managerId = "{{ $managerAccount->id ?? "" }}";
   var  url ="{{route('manager.image.index',['/'])}}/"+managerId; 
   $.get(url,function(data){
      $("#image").html(data);
   }); 


}
function zoneAttachIndex(){
 var managerId = "{{ $managerAccount->id ?? "" }}";
   var  url ="{{route('managerZoneAttachIndex',['/'])}}/"+managerId; 
   $.get(url,function(data){
      $("#zoneView").html(data);
   }); 


}

function ipAttachIndex(){
 var managerId = "{{ $managerAccount->id ?? "" }}";
   var  url ="{{route('managerIpAttach.index',['/'])}}/"+managerId; 
   $.get(url,function(data){
      $("#ipView").html(data);
   }); 
}








</script>
@endsection
