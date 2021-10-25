@extends('layouts.warehouse.app')
@section('content') 
<div id="data">
     
</div>
@endsection
@section('script')
<script>
   $(document).ready(function(){
      receivePackets();
   });

   
        function receivePackets(){
           var url = "{{ route('authorization.receive.packets') }}";
           $("#data").html("");
           $.get(url,function(data){
              $("#data").html(data);
           });
        } 

        
    </script>
@endsection
 