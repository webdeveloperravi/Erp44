@extends('layouts.store.app')
@section('content')
<div class="row"> 
   <div class="col">
    <a class="btn btn-dark float-right mb-3" href="{{ route('saleInvoice.create') }}">Create Sale Invoice</a>
    </div>
</div>
 <div class="card"> 
 <div class="card-footer p-0" style="background-color: #04a9f5">
     <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Sale Invoices</h5>
 
 </div>
  <div class="card-body">
  
    
 </div>
</div>
   
 @endsection
 @section('script')
 <script>
   function getInvoices(){  
     var userId =$("#userId").val();
       var url = "{{ route('saleInvoice.all',['/']) }}/"+userId;
       $.get(url,function(data){
          $("#all").html(data);     
       });
    }
    $(document).ready(()=>{
      getInvoices();
    });
 </script> 
   @endsection