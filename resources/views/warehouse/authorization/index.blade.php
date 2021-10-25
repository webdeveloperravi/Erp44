@extends('layouts.warehouse.app')
@section('content') 
<div class="row">
    <div class="col-sm-12">
    
    <div class="card">
    <div class="card-header">
    <h5>Material Tab</h5>
    </div>
    <div class="card-block">
    
    <div class="row m-b-30">
    <div class="col-lg-12 col-xl-12">
    <div class="sub-title">Default</div>
    
    <ul class="nav nav-tabs md-tabs" role="tablist">
    <li class="nav-item">
    <a class="nav-link" data-toggle="tab" role="tab" aria-expanded="false" onclick="invoices()">Invoices</a>
    <div class="slide"></div>
    </li> 
    <li class="nav-item">
    <a class="nav-link" data-toggle="tab" role="tab" aria-expanded="false" onclick="receivePackets()">Receive Packets</a>
    <div class="slide"></div>
    </li> 
    <li class="nav-item">
    <a class="nav-link" data-toggle="tab" role="tab" aria-expanded="false" onclick="receivePacketProcess()">Receive Process Packets</a>
    <div class="slide"></div>
    </li> 
    </ul>
    
    <div class="tab-content card-block"  id="data">
  
   
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
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
        function receivePackets(){
           var url = "{{ route('authorization.receive.packets') }}";
           $("#data").html("");
           $.get(url,function(data){
              $("#data").html(data);
           });
        }
        function receivePacketProcess(){
           var url = "{{ route('authorization.receive.packet.  process') }}";
           $("#data").html("");
           $.get(url,function(data){
              $("#data").html(data);
           });
        }

        
    </script>
@endsection
 