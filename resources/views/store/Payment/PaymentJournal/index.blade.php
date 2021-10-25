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
       var url = "{{ route('paymentJournal.create') }}/";
       $.get(url,function(data){
          $("#create").html(data);
          
         });
      // }
    }



    function store(){ 
          if($('#from').val() == $('#to').val()){
            swal('2nd Account must be different account');
          }else{
             
          
          var url = "{{ route('paymentJournal.store') }}";
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
</script> 
@endsection