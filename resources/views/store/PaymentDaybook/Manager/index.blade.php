@extends('layouts.store.app')
@section('content')
<div class="card">
   <div class="card-footer p-2" style="background-color: #04a9f5">
      <h5 class="text-white m-b-0 text-left d-inline" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Manager Payment Daybook</h5>
   </div>
   <div class="card-body">
      <form  onsubmit="event.preventDefault();" id="getTransactionsForm">
         @csrf
            <div class="row"> 
               <div class="col-md-3">
                  <div class="form-group">
                     <label for="parentId">From Payment Mode</label>
                     <select class="form-control" name="payment_mode" onchange="getAccounts(this.value)">
                        <option value="0">Select Payment Mode</option> 
                        <option value="all">All</option> 
                        <option value="cash">Cash</option> 
                        <option value="bank">Bank</option>  
                        <option value="others">Others</option>  
                     </select>
                  </div>
               </div>
                <div class="col-md-3">
                <div class="form-group"> 
                   <label for="ifscCode">Select Account</label>
                   <select class="form-control" name="account" id="accountsList"> 
                      <option value="0">Select Account</option> 
      
                   </select>
                </div> 
                </div>  
               <div class="col-md-3">
                  <div class="form-group">
                    <label for="parentId" class="invisible d-block">Hidden</label>
                      <button type="button" class="btn btn-inverse btn-sm" onclick="getTransactions()">Get</button>
                  </div>
              </div>  
      </div> 
      </form>
      <div id="transactions"></div>
   </div>
</div>

@endsection
@section('script')
 <script>
function getAccounts(storeId){ 
       var url = "{{ route('paymentDaybook.Manager.getAccounts',['/']) }}/"+storeId;
       $.get(url,function(data){
          $("#accountsList").html(data);
         }); 
}

function getTransactions(accountId){

       hideErrors();
       var url = "{{ route('paymentDaybook.Manager.getTransactions') }}";
       $.ajax({
          method:'POST',
          url: url,
          data : $("#getTransactionsForm").serialize(),
          success: function(data){
             if(data.errors){
               $.each(data.errors,function(field_name,error){
                  $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
             }); 
             }else{ 
               $("#transactions").html(data);
             }
          }
       });


     
}

 </script>
 
@endsection