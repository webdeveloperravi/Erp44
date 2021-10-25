@extends('layouts.store.app')
@section('content') 
<div class="card" id="form">
   <div class="card-footer p-0" style="background-color: #04a9f5">
      <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Manager Stock Ledger</h5>
   </div>
   <div class="card-body">
      <div class="row">
         <div class="col col-md-4">
            <form id="createForm" onsubmit="event.preventDefault();">
               @csrf
               <div class="form-group"> 
                  <label for="ifscCode">Select Manager</label>
                  <select class="form-control" onchange="getLedger(this.value)"> 
                     <option value="0">Select Manager</option> 
                     @foreach ($managers as $manager)  
                     <option value="{{ $manager->id }}">{{ $manager->name }}</option> 
                     @endforeach
                  </select>
               </div>
            </form>
         </div>
      </div>
   </div> 
   <div id="stockledgerView" class="container"> </div>
</div>
<div class="row">
   <div class="col col-md-12">
      <div id="stockTransactionDetail"></div>
   </div>
</div>


@endsection
@section('script')
<script>   
   function getLedger(id){ 
      var url = "{{ route('managerStockLedger.all',['/']) }}/"+id;
      $.get(url,function(data){
         $("#stockledgerView").html(data); 
         $("#stockTransactionDetail") .html('');     
      });
   }

   function stockTransactionDetail(id){
      var url = "{{ route('managerStockLedger.details',['/']) }}/"+id;
      $.get(url,function(data){
         $("#stockTransactionDetail") .html(data);   
         $('html, body').animate({
        scrollTop: $("#stockTransactionDetail").offset().top
    }, 2000);     
      });
   } 
</script>
@endsection