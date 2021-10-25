@extends('layouts.warehouse.app')
@section('content') 
<div id="data"> </div>
@endsection
@section('script')
<script>
   $(document).ready(function(){
      invoices();
   });

   function invoices(){
   var url = "{{ route('authorization.invoices') }}";
   $("#data").html("");
      $.get(url,function(data){
         $("#data").html(data);
      });
   } 
</script>
@endsection
 