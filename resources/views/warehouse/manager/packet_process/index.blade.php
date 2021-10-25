@extends('layouts.warehouse.app')
@section('content')  
<style>
    tfoot input {
        width: 100%;
        padding: 3px;
        box-sizing: border-box;
    }
</style>   
<div class="card">
    <div class="card-footer p-0" style="background-color: #04a9f5">
        <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">{{ $heading ?? "Error" }}</h5>
        </div> 
    <div class="card-body"> 
@if (count($challans)) 
     
        <div class="table-responsive">
            <table class="table" id="table_id2" style="width:100">
        <thead>
            <tr>
                <th>From</th>
                <th>Date</th> 
                <th>CH-No.</th>
                <th>Product</th>
                <th>Grade</th>    
                <th>Qty.</th>   
                <th>Process</th>   
                <th>Returned</th>   
                <th>Action</th>  
            </tr>
        </thead>
        <tbody>
            @foreach ($challans as $challan)   
            <tr class="text-center">
                <td>{{$challan->super->name ?? ""}}</td>
                <td>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $challan->created_at)->isoFormat('DD-MM-YYYY') }}</td> 
                {{-- <td>{{$challan->invoiceDetailGrade->invoiceDetail->invoice->invoice_number}}</td>   --}}
                <td>{{$challan->challan_number}}</td> 
                <td>{{ $challan->packet->invoiceDetailGrade->invoiceDetail->product->name}}</td> 
                <td>{{$challan->packet->invoiceDetailGrade->grade->alias}}</td>  
                <td>{{$challan->packet->total_piece}}</td>
                @if ($challan->finsh == 1)
                <td><i class="fa fa-check text-success"></i></td>
                @else
                <td><i class="fa fa-times text-danger"></i></td>
                @endif
                @if ($challan->status == 'return-to-super')
                <td><i class="fa fa-check text-success"></i></td>
                @else
                <td><i class="fa fa-times text-danger"></i></td>
                @endif

               
               
    <td> 
        @if ($challan->status == 'return-to-super')
        <a href="{{ route('packetProcess.create',$challan->packet->id) }}" class="btn btn-success btn-sm b-none">View</a>
        @elseif($challan->finsh == 1)
        <a href="{{ route('packetProcess.create',$challan->packet->id) }}" class="btn btn-dark btn-sm b-none">Return To Super</a>
        @elseif($challan->accept_challan == 1)
        <a href="{{ route('packetProcess.create',$challan->packet->id) }}" class="btn btn-info btn-sm b-none">Start Process</a>
        @else
        <button class="btn btn-dark btn-sm b-none" onclick="previewChallan({{ $challan->id }})">Preview</button>
        @endif 
    </td> 
    </tr> 
            @endforeach
        </tbody>
    </table>
</div>
@else 
<h2 class="text-center"><i class="fa fa-inbox"></i>&nbsp; No Weight Challans Left</h2> 
@endif
</div>
</div> 
<div id="previewView"></div>
@endsection
@section('script')
    <script>
      $(document).ready(function(){ 
   // Setup - add a text input to each footer cell
   $('#table_id2 tfoot th').each( function () {
       var title = $(this).text();
       $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
   } );

   // DataTable
   var table = $('#table_id2').DataTable({
       initComplete: function () {
           // Apply the search
           this.api().columns().every( function () {
               var that = this;

               $('input', this.footer() ).on( 'keyup change clear', function () {
                   if ( that.search() !== this.value ) {
                       that
                           .search( this.value )
                           .draw();
                   }
               } );
           } );
       }
   });
   });

   function previewChallan(id){
       $.get("{{ Route('packetProcess.preview',['/']) }}/"+id,function(data){
              $("#previewView").html(data);      
       });
   }

   function acceptChallan(id){
       $.get("{{ Route('packetProcess.accept',['/']) }}/"+id,function(data){
              $("#previewView").html("");
              location.reload();   
       });
   }
    </script>
 
@endsection

{{-- 

@extends('layouts.warehouse.app')
@section('content') 
 @php 
    use Carbon\Carbon;
 @endphp 

<div class="page-header">
<div class="row align-items-end">
<div class="col-lg-8">
<div class="page-header-title">
<div class="d-inline">
<h4>All Challans For Packet Prcessing</h4> 
</div>
</div>
</div>
<div class="col-lg-4">
<div class="page-header-breadcrumb">
<ul class="breadcrumb-title">
<li class="breadcrumb-item">
<a href="index.html"> <i class="feather icon-home"></i> </a>
</li>
<li class="breadcrumb-item"><a href="#!">Widget</a> </li>
</ul>
</div>
</div>
</div>
</div>


<div class="page-body invoice-list-page">
<div class="row">
 
<div class="col-xl-12 col-lg-12  filter-bar">
 

<div class="row">
    @if (!empty($challans))
        
  
 @foreach ($challans as $challan)
@php
      
@endphp
<div class="col-sm-6">
<div class="card card-border-primary">
<div class="card-header">
<h5>From : {{ $challan->super->name }} ({{ $challan->super->role->name }}) </h5>
 
</div>
<div class="card-block">
<div class="row">
<div class="col-sm-6">
<ul class="list list-unstyled">
<li>Invoice #: &nbsp;{{ $challan->packet->invoiceDetailGrade->invoiceDetail->invoice->invoice_number }}</li>
<li>Product : &nbsp;{{ $challan->packet->invoiceDetailGrade->invoiceDetail->product->name }}</li>
<li>Category : &nbsp;{{ $challan->packet->invoiceDetailGrade->invoiceDetail->assign_product->name }}</li>
<li>Issued on: <span class="text-semibold">{{ Carbon::createFromDate($challan->date)->format('d-m-Y') }}</span></li>
</ul>
</div>
<div class="col-sm-6">
<ul class="list list-unstyled text-right">
    <li>Grade: &nbsp;{{ $challan->packet->invoiceDetailGrade->grade->grade }}</li>
    <li>Weight: &nbsp;{{ $challan->packet->invoiceDetailGrade->carat.$mg }}</li>
    <li>Pieces: &nbsp;{{ $challan->packet->total_piece }}</li> 
</ul>
</div>
</div>
</div>
<div class="card-footer">
<div class="task-list-table">
 <p class="task-due"><strong> Due : </strong><strong class="label p-2 label-primary">  {{ Carbon::parse($challan->created_at)->diffForHumans()}}</strong></p>
</div>
<div class="task-board m-0">
    @if ($challan->packetProcessStatus($challan->packet->id) == false)
    @if($challan->status == 'return-to-super')
    @if ($challan->authorization == 0)
    <button class="btn btn-sm btn-warning">Waiting for Accept</button>   
    @else 
    <button class="btn btn-sm btn-success">Returned To Super</button>
    @endif
    @else
  <a href="{{ route('packetProcess.create',$challan->packet->id) }}" class="btn btn-success btn-sm b-none">Not Returned</a> 
  @endif 
    @else
    
    @if(\App\Helpers\CheckPermission::instance()->viewAction('reject-packet-process-challan'))
    <a href="{{ route('packetProcess.rejectPacket',$challan->id) }}" class="btn btn-danger btn-sm b-none">Reject Challan</a>
    @else
    <button class="btn btn-danger btn-sm b-none" onclick="noPermission()">Reject Challan</button>
    @endif
   
    @if(\App\Helpers\CheckPermission::instance()->viewAction('start-packet-process-challan'))
     <a href="{{ route('packetProcess.create',$challan->packet->id) }}" class="btn btn-info btn-sm b-none">Start Process</a>
     @else
     <button class="btn btn-info btn-sm b-none" onclick="noPermission()">Start Process</button>
     @endif
    @endif
 
</div>
</div>
</div>
</div>
@endforeach
@endif




</div>
</div>
</div>
</div> 
@endsection --}}