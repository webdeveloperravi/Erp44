@extends('layouts.store.app')
@section('css')
<style>
   th {
   text-align: left !important;
   }
</style>
@endsection
@section('content')
@if ($store)
<div class="row">
<div class="col">
  <a href="{{route('otherAccount.index')}}" class="btn btn-inverse btn-sm  m-2">Back</a>
</div>
</div>  
<div id="verifyAccount"> </div>
    
<div id="main">
<div class="card">
    <!--Header ---->
    <div class="card-footer p-0" style="background-color: #04a9f5">
      <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">{{$store->company_name}}</h5>
     </div>
    
    <div class="card-body"> 
    <div class="row">

    <div class="col col-md-6">

    <div class="row">
      
      <div class="col col-md-3">
        <img src="{{ asset('public/images/lead-images/abc.jpg') }}" alt="" class="img-fluid img-thumbnail" width="100">
      </div>

      <div class="col-md-9">
      <h6><span>{{$store->company_name ?? ''}}</span></h6>
      <h6><span>{{$store->role->name ?? ''}}</span></h6>
      {{-- <h6><span><a target="_blank" href="{{ App\Helpers\StoreHelper::getStoreSubDomainUrl($store->id) ?? "" }}">{{ App\Helpers\StoreHelper::getStoreSubDomainUrl($store->id) ?? ""}}</a> </span></h6> --}}
      <h6><span>+{{$store->getPhoneWithCode($store->id)?? ''}}</span></h6>
      </div>

     </div>
    </div>
    <!---Left Div---->
    <div class="col col-lg-6 col-md-6">
      <div class="row">
     <div class="col mb-2">
      @if($store->email_verify == 1 && $store->phone_verify==1)
      <button   class="btn btn-sm btn-success f-right"><i class="fa fa-check text-white"></i>Verified Account</button>
      @else
      <button class="btn btn-danger btn-sm f-right m-r-2" onclick="verifyAccount('{{$store->id}}')">Verify Now</button>
 
       
      @endif 
    </div> 
 
    </div> 
  </div>  
  <div class="col-md-12" id="index">
 </div>  

</div>
</div><!---card Body Div close-->
</div><!--Card Div Close-->
</div><!---Main Div Close-->
<!---Sub Other Index --->



<div id="create"></div>
 
@endif
@endsection
@section('script')
<script>
subOtherIndex(); 

function verifyAccount(accountId)
{
    var url = "{{route('store.verify.view',['/'])}}/"+accountId;
    $.get(url,function(data){

        $("#verifyAccount").html(data);
    }); 
}

function edit(accountId){

var  url ="{{route('otherAccount.edit',['/'])}}/"+accountId;
    $.get(url,function(data){

        $("#edit").html(data);
    });
}



function subOtherIndex(){

 var url ="{{route('otherAccount.subIndex',['/'])}}/"+"{{$store->id}}";
 $.get(url,function(data){

  $("#index").html(data);
 });



}



















</script>
@endsection