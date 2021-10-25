@extends('layouts.store.app')
@section('content') 

<div class="row"> 
  <div class="col">
    <button class="btn btn-dark  float-right mb-2" onclick="createCustomerAccount()">Create Customer</button>
   </div>
</div> 
<div id="create"></div>
<div id="all"></div>

@endsection
@section('script')
<script>
    $(document).ready(function(){
      //   createCustomerAccount();
        getCustomerAccounts();   
    });
 

function createCustomerAccount(){ 

  var url = "{{ route('customerAccount.create') }}";
  $.get(url,function(data){
     $("#create").html(data);
  });
}

function saveCustomer()
{
  $.ajax({
    url : "{{ route('customerAccount.save') }}",
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
      swal(data.message);
      $("#create").html("");
        getCustomerAccounts();
     }
  },
  });
}

function hideErrors(){ 
   $(".text-danger").remove(); 
   $("input").removeClass('input-error'); 
   $("select").removeClass('input-error'); 
 }

function getCustomerAccounts(){
var url = "{{ route('customer.getAccounts') }}";
$.get(url,function(data){
   $("#all").html(data);
});
}

function verifyAccount(accountId)
{

  alert(accountId);
}

</script>
@endsection