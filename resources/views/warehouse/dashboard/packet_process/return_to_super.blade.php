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
<h4>All Packets </h4>
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
@if (!empty($packets))
@foreach ($packets as $packet)
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
<li>Invoice #: &nbsp;{{$packet->invoiceDetailGrade->invoiceDetail->invoice->invoice_number }}</li>
<li>Product : &nbsp;{{$packet->invoiceDetailGrade->invoiceDetail->product->name }}</li>
<li>Category : &nbsp;{{$packet->invoiceDetailGrade->invoiceDetail->assign_product->name}}</li>
<li>Issued on: <span class="text-semibold<!-- ">{{ Carbon::parse($packet->created_at)->format('d-m-Y') }}</span></li>
</ul>
</div>
<div class="col-sm-6">
<ul class="list list-unstyled text-right">
    <li>Packet Number #: &nbsp;{{ $packet->number}}</li>
    <li>Grade: &nbsp;{{ $packet->invoiceDetailGrade->grade->grade }}</li>
    <li>Total Pieces: &nbsp;{{ $packet->invoiceDetailGrade->piece }}</li> 
</ul>
</div>
</div>
</div>
<div class="card-footer">
<div class="task-list-table">
 <p class="task-due"><strong> created on : </strong><strong class="label p-2 label-primary">{{ Carbon::parse($packet->updated_at)->format('d-m-Y')}}</strong></p>
</div>
<div class="task-board m-0">

@if($packet->return_to_super==1)    
<button class="btn btn-sm btn-dark">Returned To Super</button>
@else
<a href="{{ route('packet.return',$packet->id) }}" class="btn btn-sm btn-primary">Return To Super</a>
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