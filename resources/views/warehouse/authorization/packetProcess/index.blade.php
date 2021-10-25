@extends('layouts.warehouse.app')
@section('content') 
<div id="data"> </div>
@endsection
@section('script')
<script>
   $(document).ready(function(){
      receivePacketProcess();
   });
   function receivePacketProcess(){
      var url = "{{ route('authorization.receive.packet.process') }}";
      $("#data").html("");
      $.get(url,function(data){
         $("#data").html(data);
      });
   }
</script>
@endsection
 