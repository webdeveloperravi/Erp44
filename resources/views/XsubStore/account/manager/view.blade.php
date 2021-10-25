@extends('layouts.store.app')
@section('content') 
<div id="verifyAccount"> </div>
<div id="create"></div>
<div id="edit"></div>
<div class="card">
    <div class="card-header">
      <h4>Store Name : {{$managerAccount->parentStore->name}}</h4>
      <h4 class="card-header-text">Manager Account Detail</h4>
      @if($managerAccount->email_verify == 1 && $managerAccount->phone_verify==1)
      <a  onclick="verifyAccount('{{$managerAccount->id}}')" class="btn btn-sm btn-success f-right"><i class="fa fa-check text-white"></i>Verifed Account</a> 
         <a href="{{route('storeAccount.view',$managerAccount->parentStore->id)}}" type="button" class="btn btn-sm btn-warning waves-effect waves-light f-right mr-3">
      Back</a>
      @else
      <button class="btn btn-inverse btn-sm f-right m-r-2" onclick="verifyAccount('{{$managerAccount->id}}')">Verify Account</button> 

      <button id="edit-btn" type="button" class="btn btn-sm btn-primary waves-effect waves-light f-right mr-3" onclick="edit('{{$managerAccount->id}}')">
      Edit
      </button>
      <a href="{{ url()->previous() }}" type="button" class="btn btn-sm btn-warning waves-effect waves-light f-right mr-3">
      Back</a>
      
      @endif
   </div>
   <div class="card-block">
      <div class="row table-responsive">
         <table class="table">
            <tr>
               <th>Name</th>
               <td>{{$managerAccount->name ?? ''}}</td> 
               <th>Email ID </th>
               <td>{{$managerAccount->email ?? ''}}</td>
                <th>Manager Role Name</th>
               <td>{{$managerAccount->managerRole->name ?? ''}}</td>
            </tr>
            <tr>
               <th>Phone </th>
               <td>{{$managerAccount->phone ?? ''}}</td>
               <th>Status</th>
               <td>@if($managerAccount->email_verify==1 && $managerAccount->phone_verify==1)
                  Verified
                  @else 
                  Not Account Verify
                  @endif
               </td>
            </tr>
         </table>
      </div>
   </div>

<ul class="nav nav-tabs m-2" role="tablist" >
   {{-- <li class="nav-item">
     <a class="nav-link active" data-toggle="tab" href="#nav_details">Details</a>
   </li> --}}
   <li class="nav-item">
     <a class="nav-link active" data-toggle="tab" href="#nav_address" onclick="storeAddressIndex()">Address</a>
   </li>  
 </ul>


 <div class="tab-content">
   {{-- <div id="nav_details" class="container tab-pane active"><br>
   <div id="detail">
   

   </div>
</div> --}}
   <div id="nav_address" class="container tab-pane active"><br>
     <div id="addressIndex3"> </div> 
   

   </div>
 </div>
 </div>
{{-- <div id="addressIndex"> </div>  --}}
@endsection
@section('script')
<script>
 

 storeAddressIndex();

 function storeAddressIndex()
{   
   var storeId = "{{ $managerAccount->id ?? "" }}";
   var  url ="{{route('managerAccount.address.index',['/'])}}/"+storeId; 
   $.get(url,function(data){
      $("#addressIndex3").html(data);
   }); 
}


// Manager Account function
  function verifyAccount(accountId)
{
    var url = "{{route('subStore.manager.verify.view',['/'])}}/"+accountId;
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
var  url ="{{route('subStore.managerAccount.edit',['/'])}}/"+accountId;
    $.get(url,function(data){

        $("#edit").html(data);
    });

}

</script>
@endsection