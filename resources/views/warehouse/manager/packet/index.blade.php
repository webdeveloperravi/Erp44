@extends('layouts.warehouse.app')
@section('content') 
 @php 
    use Carbon\Carbon;
 @endphp
<div class="page-wrapper">

<div class="page-header">
<div class="row align-items-end">
<div class="col-lg-8">
<div class="page-header-title">
<div class="d-inline">
<h4>Ready for packets</h4>
<span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span>
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

<nav class="navbar navbar-light bg-faded m-b-30 p-10">
<ul class="nav navbar-nav">
<li class="nav-item active">
<a class="nav-link" href="#!">Filter: <span class="sr-only">(current)</span></a>
</li>
<li class="nav-item dropdown">
<a class="nav-link dropdown-toggle" href="#!" id="bydate" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icofont icofont-clock-time"></i> By Date</a>
<div class="dropdown-menu" aria-labelledby="bydate">
<a class="dropdown-item" href="#!">Show all</a>
<div class="dropdown-divider"></div>
<a class="dropdown-item" href="#!">Today</a>
<a class="dropdown-item" href="#!">Yesterday</a>
<a class="dropdown-item" href="#!">This week</a>
<a class="dropdown-item" href="#!">This month</a>
<a class="dropdown-item" href="#!">This year</a>
</div>
</li>

<li class="nav-item dropdown">
 <a class="nav-link dropdown-toggle" href="#!" id="bystatus" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icofont icofont-chart-histogram-alt"></i> By Status</a>
<div class="dropdown-menu" aria-labelledby="bystatus">
<a class="dropdown-item" href="#!">Show all</a>
<div class="dropdown-divider"></div>
<a class="dropdown-item" href="#!">Open</a>
<a class="dropdown-item" href="#!">On hold</a>
<a class="dropdown-item" href="#!">Resolved</a>
<a class="dropdown-item" href="#!">Closed</a>
<a class="dropdown-item" href="#!">Dublicate</a>
<a class="dropdown-item" href="#!">Wontfix</a>
</div>
</li>

<li class="nav-item dropdown">
<a class="nav-link dropdown-toggle" href="#!" id="bypriority" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icofont icofont-sub-listing"></i> By Priority</a>
<div class="dropdown-menu" aria-labelledby="bypriority">
<a class="dropdown-item" href="#!">Show all</a>
<div class="dropdown-divider"></div>
<a class="dropdown-item" href="#!">Highest</a>
<a class="dropdown-item" href="#!">High</a>
<a class="dropdown-item" href="#!">Normal</a>
<a class="dropdown-item" href="#!">Low</a>
</div>
</li>
</ul>
<div class="nav-item nav-grid">
<span class="m-r-15">View Mode: </span>
<button type="button" class="btn btn-sm btn-primary  m-r-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="list view">
<i class="icofont icofont-listine-dots"></i>
</button>
<button type="button" class="btn btn-sm btn-primary " data-toggle="tooltip" data-placement="top" title="" data-original-title="grid view">
<i class="icofont icofont-table"></i>
</button>
</div>

</nav>

<div class="row">
 @if (!empty($challans))
@foreach ($challans as $challan)
@php
    // dd(date_format($challan->date,"Y/m/d H:i:s"));
    // dd(date_format($challan->date,"Y/m/d H:i:s"));
    // dd(date('Y-m-d',$challan->date));
    // dd();
    
@endphp
<div class="col-sm-6">
<div class="card card-border-primary">
<div class="card-header">
<h5>From : {{ $challan->super->name }} ({{ $challan->super->role->name }}) </h5>
<div class="dropdown-secondary dropdown f-right">
<button class="btn btn-primary btn-mini dropdown-toggle " type="button" id="dropdown1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Overdue</button>
<div class="dropdown-menu" aria-labelledby="dropdown1" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut" x-placement="bottom-start" style="position: absolute; transform: translate3d(49px, 26px, 0px); top: 0px; left: 0px; will-change: transform;">
<a class="dropdown-item waves-light waves-effect" href="#!"><span class="point-marker bg-danger"></span>Pending</a>
<a class="dropdown-item waves-light waves-effect" href="#!"><span class="point-marker bg-warning"></span>Paid</a>
<div class="dropdown-divider"></div>
<a class="dropdown-item waves-light waves-effect active" href="#!"><span class="point-marker bg-success"></span>On Hold</a>
<a class="dropdown-item waves-light waves-effect" href="#!"><span class="point-marker bg-info"></span>Canceled</a>
</div>

<span class="f-left m-r-5 text-inverse">Status : </span>
</div>
</div>
<div class="card-block">
<div class="row">
<div class="col-sm-6">
<ul class="list list-unstyled">
<li>Invoice #: &nbsp;{{ $challan->invoiceDetailGrade->invoiceDetail->invoice->invoice_number }}</li>
<li>Product : &nbsp;{{ $challan->invoiceDetailGrade->invoiceDetail->product->name }}</li>
<li>Category : &nbsp;{{ $challan->invoiceDetailGrade->invoiceDetail->assign_product->name }}</li>
{{-- <li>Issued on: <span class="text-semibold">{{ ($challan->date)->format('Y-m-d') }}</span></li> --}}
</ul>
</div>
<div class="col-sm-6">
<ul class="list list-unstyled text-right">
    <li>Grade: &nbsp;{{ $challan->invoiceDetailGrade->grade->grade }}</li>
    <li>Weight: &nbsp;{{ $challan->invoiceDetailGrade->carat.$mg }}</li>
    <li>Pieces: &nbsp;{{ $challan->invoiceDetailGrade->piece }}</li>
<li>Method: <span class="text-semibold">SWIFT</span></li>
</ul>
</div>
</div>
</div>
<div class="card-footer">
<div class="task-list-table">
 <p class="task-due"><strong> Due : </strong><strong class="label label-primary">{{ Carbon::parse($challan->updated_at)->diffForHumans()}}</strong></p>
</div>
<div class="task-board m-0">

<a href="{{ route('manager.challan.packet.all',$challan->invoiceDetailGrade->id) }}" class="btn btn-info btn-mini b-none">Start Packaging</a>

<div class="dropdown-secondary dropdown">
<button class="btn btn-info btn-mini dropdown-toggle waves-light b-none txt-muted" type="button" id="dropdown14" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icofont icofont-navigation-menu"></i></button>
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
</div>
@endsection