@extends('layouts.store.app')
@section('content') 
   
   <div class="card" id="create">
      
      </div> 
 
@endsection
@section('script')
<script> 
    create();
    function create(){
      // if(storeId != 0){
       var url = "{{ route('paymentReceive.create') }}/";
       $.get(url,function(data){
          $("#create").html(data);
          
         });
      // }
    }

   function getPaymentModeAcounts(paymentMode){
      if(paymentMode != 0){
     var url = "{{ route('paymentReceive.getPaymentModeAccounts',['/'])}}/"+paymentMode;
      $.get(url,function(data){
         $("#paymentModeAccountsList").html(data);
         $("#paymentModeAccountsList").trigger('change');
      });
      }
    }

    function getStoreAccounts(storeId){
      if(storeId != 0){
       var url = "{{ route('paymentReceive.getStoreManagers',['/']) }}/"+storeId;
       $.get(url,function(data){
          $("#accountsList").html(data);
         });
      }
    }

    function store(){
       
       if($(document).find('[name=from]').val() == $(document).find('[name=to]').val()){
          swal('Account must be different');
       }else{
         hideErrors();
       var url = "{{ route('paymentReceive.save') }}";
       $.ajax({
          method:'POST',
          url: url,
          data : $("#createForm").serialize(),
          success: function(data){
             if(data.errors){
               $.each(data.errors,function(field_name,error){
                  $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
             }); 
            }
             if(!data.success){
               swal(data.msg);    
            }
             else{ 
               create(); 
               swal(data.msg);
             }
          
       }
       });
       }

      
    }
    
    $('#date1').datepicker({
      dateFormat: "dd-mm-yy", 

    });

        
    function getBalance(accountId){
       var url = "{{ route('getBalance',['/']) }}/"+accountId;
       $.get(url,function(data){
           $("#balance").html(data);
            getLastTransactions(accountId);
       });
    }

        
    function getLastTransactions(accountId){
       var url = "{{ route('paymentReceive.getLastTransactions',['/']) }}/"+accountId;
       $.get(url,function(data){
           $("#lastTransactions").html(data);
       });
    }


</script> 
@endsection
 