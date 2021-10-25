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
<h4>All Issued Packets from super </h4>
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
@if (!empty($issuedPacketsSuper))
@foreach ($issuedPacketsSuper as $issue_packet)
@php

@endphp
<div class="col-sm-6">
<div class="card card-border-primary">
<div class="card-header">
</div>
<div class="card-block">
<div class="row">
<div class="col-sm-6">
<ul class="list list-unstyled">
<li>Invoice #: &nbsp;{{($issue_packet->packet->invoiceDetailGrade->invoiceDetail->invoice->invoice_number)}}</li>
<li>Product : &nbsp;{{$issue_packet->packet->invoiceDetailGrade->invoiceDetail->product->name}}</li>
<li>Category : &nbsp;{{$issue_packet->packet->invoiceDetailGrade->invoiceDetail->assign_product->name}}</li>
<li>Issued on: <span class="text-semibold<!-- ">{{ Carbon::parse($issue_packet->created_at)->format('d-m-Y') }}</span></li>
</ul>
</div>
<div class="col-sm-6">
<ul class="list list-unstyled text-right">
    <li>Packet Number #: &nbsp;{{ $issue_packet->challan_number}}</li>
    <li>Grade: &nbsp;{{$issue_packet->packet->invoiceDetailGrade->grade->grade }}</li>
     <li>Weight: &nbsp;{{ $issue_packet->packet->invoiceDetailGrade->carat.$mg }}</li>
    <li>Ratti: &nbsp;{{ $issue_packet->packet->ratti->rati_standard }}</li>
    <li>Total Pieces: &nbsp;{{ $issue_packet->packet->total_piece }}</li> 
</ul>
</div>
</div>
</div>

<div class="card-footer">
<div class="task-list-table">
 <p class="task-due"><strong> Due : </strong><strong class="label p-2 label-primary">  {{ Carbon::parse($issue_packet->created_at)->diffForHumans()}}</strong></p>
</div>
<div class="task-board m-0">
    @if ($issue_packet->packetProcessStatus($issue_packet->packet_id) == false)
    @if($issue_packet->status == 'return-to-super')
    <button class="btn btn-sm btn-success">Returned To Super</button>
    @else
  <a href="{{ route('packetProcess.create',$issue_packet->packet_id) }}" class="btn btn-success btn-sm b-none">Process Complete</a> 
  @endif 
    @else
    <a href="{{ route('packetProcess.rejectPacket',$issue_packet->id) }}" class="btn btn-danger btn-sm b-none">Reject Challan</a>
     <a href="{{ route('packetProcess.create',$issue_packet->packet_id) }}" class="btn btn-info btn-sm b-none">Start Process</a> 
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
@endsection