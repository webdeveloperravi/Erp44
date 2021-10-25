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
<h4>All Challans For Weight</h4>
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
<div class="dropdown-secondary dropdown f-right">
 
 

<span class="f-left m-r-5 text-inverse"><h5>To : {{ $challan->manager->name }} </h5></span>
</div>
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
    <li>Weight: &nbsp;{{ $challan->packet->invoiceDetailGrade->carat .$mg}}</li>
    <li>Pieces: &nbsp;{{ $challan->packet->invoiceDetailGrade->piece }}</li> 
    <li>Completed On: &nbsp;{{Carbon::parse($challan->updated_at)->format('Y-m-d') }}</li> 
</ul>
</div>
</div>
</div>
<div class="card-footer">
<div class="task-list-table">
 <p class="task-due"><strong> Due : </strong><strong class="label p-2 label-primary">  {{ Carbon::parse($challan->created_at)->diffForHumans()}}</strong></p>
</div>
<div class="task-board m-0"> 
    <button class="btn btn-success btn-sm b-none">{{ ucwords(str_replace("-", " ", $challan->status))  }}</button>
    
 
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