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
{{-- <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span> --}}
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

  <div class="dropdown-secondary dropdown">
<button class="btn btn-info btn-sm dropdown-toggle waves-light b-none txt-muted" type="button" id="dropdown14" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icofont icofont-navigation-menu"></i></button>
<div class="dropdown-menu" aria-labelledby="dropdown14" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut" x-placement="top-start" style="position: absolute; transform: translate3d(0px, -2px, 0px); top: 0px; left: 0px; will-change: transform;">
<a class="dropdown-item waves-light waves-effect" href="#!"><i class="icofont icofont-ui-alarm"></i> Print Invoice</a>
<a class="dropdown-item waves-light waves-effect" href="#!"><i class="icofont icofont-attachment"></i> Download invoice</a>
<div class="dropdown-divider"></div>
<a class="dropdown-item waves-light waves-effect" href="#!"><i class="icofont icofont-spinner-alt-5"></i> Edit Invoice</a>
<a class="dropdown-item waves-light waves-effect" href="#!"><i class="icofont icofont-ui-edit"></i> Remove Invoice</a>
</div>
</div>  
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
@endsection