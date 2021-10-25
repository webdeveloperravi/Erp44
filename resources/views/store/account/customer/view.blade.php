@extends('layouts.store.app')
@section('css')
 <style>
  th {
  text-align: left !important;
}

 </style>
@endsection
@section('content')
 
<div id="verifyAccount"> </div>
<div id="create"></div>
<div id="edit"></div>
<div class="card">
    <div class="card-header">
      <h4 class="card-header-text">Account Detail</h4>
      @if($store->email_verify == 1 && $store->phone_verify==1)
      <a  onclick="verifyAccount('{{$store->id}}')" class="btn btn-sm btn-success f-right"><i class="fa fa-check text-white"></i>Verifed Account</a>
         <a href="{{ route('customerAccount.index') }}" type="button" class="btn btn-sm btn-warning waves-effect waves-light f-right mr-3">
      Back</a>
      @else
      <button class="btn btn-inverse btn-sm f-right m-r-2" onclick="verifyAccount('{{$store->id}}')">Verify Account</button> 

      <button id="edit-btn" type="button" class="btn btn-sm btn-primary waves-effect waves-light f-right mr-3" onclick="edit('{{$store->id}}')">
      Edit
      </button>
      <a href="{{ route('customerAccount.index') }}" type="button" class="btn btn-sm btn-warning waves-effect waves-light f-right mr-3">
      Back</a>
      
      @endif
   </div>
   <div class="card-block">
      <div class="row table-responsive">
         <table class="table">
            <tr>
               <th>Owner Name</th>
               <td>{{$store->name ?? ''}}</td>
               <th>Email ID </th>
               <td>{{$store->email ?? ''}}</td>
               <th>Phone </th>
               <td>{{$store->phone ?? ''}}</td>
            </tr>
            <tr>
             
               <th>Status</th>
               <td>@if($store->email_verify==1 && $store->phone_verify==1)
                  Verified
                  @else 
                  Not Account Verify
                  @endif
               </td>
            </tr>
         </table>
      </div>
   </div>
</div>

<div id="addressIndex"> </div> 
  
@endsection
@section('script')
<script>
  
  storeAddressIndex();

function storeAddressIndex()
{   
   var storeId = "{{ $store->id ?? "" }}";
   var  url ="{{route('customerAccount.address.index',['/'])}}/"+storeId; 
   $.get(url,function(data){
      $("#addressIndex").html(data);
   }); 
}

  function verifyAccount(accountId)
{
    var url = "{{route('customer.verify.view',['/'])}}/"+accountId;
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

var  url ="{{route('customerAccount.edit',['/'])}}/"+accountId;
    $.get(url,function(data){

        $("#edit").html(data);
    })
     var offset = $("#edit").offset();
         $('html, body').animate({
            scrollTop: offset.top,
            scrollLeft: offset.left
         }, 1000);
} 


</script>
@endsection