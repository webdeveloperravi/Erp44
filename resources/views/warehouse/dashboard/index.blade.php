@extends('layouts.warehouse.app')
@section('content')

@php 
@endphp
@if(auth('warehouse')->user()->role->id=='1')
<h1>Super Dashboard</h1>
<div class="row">
   <div class="col-xl-3 col-md-6">
      <a href="{{ route('warehouse.dashboard.invoice.pending') }}" class="">
         <div class="card">
            <div class="card-block">
               <div class="row align-items-center">
                  <div class="col-9">
                     <h4 class="text-c-green f-w-600">{{ $draftPurchaseInvoices }}</h4>
                     {{-- 
                     <h6 class="text-muted m-b-0">Incomplete Purchase Invoices</h6>
                     --}}
                  </div>
                  <div class="col-3 text-right">
                     <i class="feather icon-file-text f-28"></i>
                  </div>
               </div>
            </div>
            <div class="card-footer bg-c-yellow">
               <div class="row align-items-center">
                  <div class="col-12">
                     <p class="text-white m-b-0">Draft Purchase Invoices</p>
                  </div>
                  {{-- 
                  <div class="col-3 text-right">
                     <i class="feather icon-trending-up text-white f-16"></i>
                  </div>
                  --}}
               </div>
            </div>
         </div>
      </a>
   </div>
   <div class="col-xl-3 col-md-6">
      <a href="{{ route('authorization.invoiceIndex') }}" class="">
         <div class="card">
            <div class="card-block">
               <div class="row align-items-center">
                  <div class="col-9">
                     <h4 class="text-c-green f-w-600">{{ $unauthorizedInvoices }}</h4>
                     {{-- 
                     <h6 class="text-muted m-b-0">Unauthorized Invoices</h6>
                     --}}
                  </div>
                  <div class="col-3 text-right">
                     <i class="feather icon-file-text f-28"></i>
                  </div>
               </div>
            </div>
            <div class="card-footer bg-c-yellow">
               <div class="row align-items-center">
                  <div class="col-12">
                     <p class="text-white m-b-0">Unauthorized Invoices</p>
                  </div>
                  {{-- 
                  <div class="col-3 text-right">
                     <i class="feather icon-trending-up text-white f-16"></i>
                  </div>
                  --}}
               </div>
            </div>
         </div>
      </a>
   </div>
   <div class="col-xl-3 col-md-6">
      <a href="{{ route('warehouse.dashboard.invoice.complete') }}" class="">
         <div class="card">
            <div class="card-block">
               <div class="row align-items-center">
                  <div class="col-8">
                     <h4 class="text-c-yellow f-w-600">{{ $completedInvoices }}</h4>
                     {{-- 
                     <h6 class="text-muted m-b-0">Complete Invoices</h6>
                     --}}
                  </div>
                  <div class="col-4 text-right">
                     <i class="feather icon-bar-chart f-28"></i>
                  </div>
               </div>
            </div>
            <div class="card-footer bg-c-green ">
               <div class="row align-items-center">
                  <div class="col-12">
                     <p class="text-white m-b-0">Purchase Invoice Final</p>
                     {{-- 
      <a href="{{ route('invoice.index') }}" class="btn btn-sm btn-primary float-right">View All</a> --}}
      </div>
      {{-- <div class="col-3 ">
      <i class="feather icon-trending-up text-white f-16"></i>
      </div>  
      --}}
      </div>
      </div>
      </div>
      </a>
   </div>
   <div class="col-xl-3 col-md-6">
      <a href="{{ route('warehouse.dashboard.invoice.gradesortPending') }}">
         <div class="card">
            <div class="card-block">
               <div class="row align-items-center">
                  <div class="col-10">
                     <h4 class="text-c-pink f-w-600">{{ $gradesortPendingInvoices }}</h4>
                     {{-- 
                     <h6 class="text-muted m-b-0">Gradesort Pending</h6>
                     --}}
                  </div>
                  <div class="col-2 text-right">
                     <i class="feather icon-calendar f-28"></i>
                  </div>
               </div>
            </div>
            <div class="card-footer bg-c-pink">
               <div class="row align-items-center">
                  <div class="col-12">
                     <p class="text-white m-b-0">GradeSort Pending</p>
                  </div>
                  {{-- 
                  <div class="col-3 text-right">
                     <i class="feather icon-trending-up text-white f-16"></i>
                  </div>
                  --}}
               </div>
            </div>
         </div>
      </a>
   </div>
   <div class="col-xl-3 col-md-6">
      <a href="{{ route('warehouse.dashboard.invoice.generateIdPending') }}">
         <div class="card">
            <div class="card-block">
               <div class="row align-items-center">
                  <div class="col-8">
                     <h4 class="text-c-blue f-w-600">{{ $generateIdPendingInvoices }}</h4>
                     {{-- 
                     <h6 class="text-muted m-b-0">Generate ID Pending</h6>
                     --}}
                  </div>
                  <div class="col-4 text-right">
                     <i class="feather icon-download f-28"></i>
                  </div>
               </div>
            </div>
            <div class="card-footer" style="background-color: #04a9f5">
               <div class="row align-items-center">
                  <div class="col-12">
                     <p class="text-white m-b-0">Generate ID Pending</p>
                  </div>
                  {{-- 
                  <div class="col-3 text-right">
                     <i class="feather icon-trending-up text-white f-16"></i>
                  </div>
                  --}}
               </div>
            </div>
         </div>
      </a>
   </div>
   <div class="col-xl-3 col-md-6">
      <a href="{{ route('warehouse.dashboard.invoice.notIssuedToManager') }}">
         <div class="card">
            <div class="card-block">
               <div class="row align-items-center">
                  <div class="col-8">
                     <h4 class="text-c-blue f-w-600">{{ $notIssuedForWeight }}</h4>
                     {{-- 
                     <h6 class="text-muted m-b-0">Issue for Weight Pending</h6>
                     --}}
                  </div>
                  <div class="col-4 text-right">
                     <i class="feather icon-download f-28"></i>
                  </div>
               </div>
            </div>
            <div class="card-footer" style="background-color: #04a9f5">
               <div class="row align-items-center">
                  <div class="col-12">
                     <p class="text-white m-b-0">Issue for Weight Pending</p>
                  </div>
                  {{-- 
                  <div class="col-3 text-right">
                     <i class="feather icon-trending-up text-white f-16"></i>
                  </div>
                  --}}
               </div>
            </div>
         </div>
      </a>
   </div>
   <div class="col-xl-3 col-md-6">
      <a href="{{ route('warehouse.dashboard.challansForWeight') }}">
         <div class="card">
            <div class="card-block">
               <div class="row align-items-center">
                  <div class="col-8">
                     <h4 class="text-c-blue f-w-600">{{ $issuedWeightChallans }}</h4>
                     {{-- 
                     <h6 class="text-muted m-b-0">Issued Weight Challans</h6>
                     --}}
                  </div>
                  <div class="col-4 text-right">
                     <i class="feather icon-download f-28"></i>
                  </div>
               </div>
            </div>
            <div class="card-footer" style="background-color: #04a9f5">
               <div class="row align-items-center">
                  <div class="col-12">
                     <p class="text-white m-b-0">Issued Weight Challans</p>
                  </div>
                  {{-- 
                  <div class="col-3 text-right">
                     <i class="feather icon-trending-up text-white f-16"></i>
                  </div>
                  --}}
               </div>
            </div>
         </div>
      </a>
   </div>
   <div class="col-xl-3 col-md-6">
      <a href="{{ route('authorization.receivePacketIndex') }}">
         <div class="card">
            <div class="card-block">
               <div class="row align-items-center">
                  <div class="col-8">
                     <h4 class="text-c-blue f-w-600">{{ $acceptWeightChallanPackets }}</h4>
                     {{-- 
                     <h6 class="text-muted m-b-0">Issued Weight Challans</h6>
                     --}}
                  </div>
                  <div class="col-4 text-right">
                     <i class="feather icon-download f-28"></i>
                  </div>
               </div>
            </div>
            <div class="card-footer" style="background-color: #04a9f5">
               <div class="row align-items-center">
                  <div class="col-12">
                     <p class="text-white m-b-0">Pending Packets to Accept</p>
                  </div>
                  {{-- 
                  <div class="col-3 text-right">
                     <i class="feather icon-trending-up text-white f-16"></i>
                  </div>
                  --}}
               </div>
            </div>
         </div>
      </a>
   </div>
   <div class="col-xl-3 col-md-6">
      <a href="{{ route('warehouse.dashboard.manager.packetProcessNotIssued') }}">
         <div class="card">
            <div class="card-block">
               <div class="row align-items-center">
                  <div class="col-8">
                     <h4 class="text-c-blue f-w-600">{{ $notIssuedPacketProcess }}</h4>
                     {{-- 
                     <h6 class="text-muted m-b-0">Issued Weight Challans</h6>
                     --}}
                  </div>
                  <div class="col-4 text-right">
                     <i class="feather icon-download f-28"></i>
                  </div>
               </div>
            </div>
            <div class="card-footer" style="background-color: #04a9f5">
               <div class="row align-items-center">
                  <div class="col-12">
                     <p class="text-white m-b-0">Issue Packet Process Pending</p>
                  </div>
                  {{-- 
                  <div class="col-3 text-right">
                     <i class="feather icon-trending-up text-white f-16"></i>
                  </div>
                  --}}
               </div>
            </div>
         </div>
      </a>
   </div>
   <div class="col-xl-3 col-md-6">
      <a href="{{ route('warehouse.dashboard.manager.packetProcessIssued') }}">
         <div class="card">
            <div class="card-block">
               <div class="row align-items-center">
                  <div class="col-8">
                     <h4 class="text-c-blue f-w-600">{{ $packetProcessingChallans }}</h4>
                     {{-- 
                     <h6 class="text-muted m-b-0">Challans For Packet</h6>
                     --}}
                  </div>
                  <div class="col-4 text-right">
                     <i class="feather icon-download f-28"></i>
                  </div>
               </div>
            </div>
            <div class="card-footer" style="background-color: #04a9f5">
               <div class="row align-items-center">
                  <div class="col-12">
                     <p class="text-white m-b-0">Issued Packet Process Challans</p>
                  </div>
                  {{-- 
                  <div class="col-3 text-right">
                     <i class="feather icon-trending-up text-white f-16"></i>
                  </div>
                  --}}
               </div>
            </div>
         </div>
      </a>
   </div>
   <div class="col-xl-3 col-md-6">
      <a href="{{ route('authorization.packetProcessIndex') }}">
         <div class="card">
            <div class="card-block">
               <div class="row align-items-center">
                  <div class="col-8">
                     <h4 class="text-c-blue f-w-600">{{ $pendingProcessPacketsToAccept }}</h4>
                     {{-- 
                     <h6 class="text-muted m-b-0">Challans For Packet</h6>
                     --}}
                  </div>
                  <div class="col-4 text-right">
                     <i class="feather icon-download f-28"></i>
                  </div>
               </div>
            </div>
            <div class="card-footer" style="background-color: #04a9f5">
               <div class="row align-items-center">
                  <div class="col-12">
                     <p class="text-white m-b-0">Pending Packet Process to Accept</p>
                  </div>
                  {{-- 
                  <div class="col-3 text-right">
                     <i class="feather icon-trending-up text-white f-16"></i>
                  </div>
                  --}}
               </div>
            </div>
         </div>
      </a>
   </div>
   <div class="col-xl-3 col-md-6">
      <a href="{{ route('packet.product.index') }}">
         <div class="card">
            <div class="card-block">
               <div class="row align-items-center">
                  <div class="col-8">
                     <h4 class="text-c-blue f-w-600">{{ $finalPackets }}</h4>
                     {{-- 
                     <h6 class="text-muted m-b-0">Challans For Packet</h6>
                     --}}
                  </div>
                  <div class="col-4 text-right">
                     <i class="feather icon-download f-28"></i>
                  </div>
               </div>
            </div>
            <div class="card-footer" style="background-color: #04a9f5">
               <div class="row align-items-center">
                  <div class="col-12">
                     <p class="text-white m-b-0">Final Packets</p>
                  </div>
                  {{-- 
                  <div class="col-3 text-right">
                     <i class="feather icon-trending-up text-white f-16"></i>
                  </div>
                  --}}
               </div>
            </div>
         </div>
      </a>
   </div>
</div>
@else 
<h1>Manager dashboard</h1>
<div class="row">
   <div class="col-xl-3 col-md-6">
      <a href="{{ route('warehouse.dashboard.invoice.pending') }}" class="">
         <div class="card">
            <div class="card-block">
               <div class="row align-items-center">
                  <div class="col-9">
                     <h4 class="text-c-green f-w-600">{{ $draftPurchaseInvoices }}</h4>
                     {{-- 
                     <h6 class="text-muted m-b-0">Incomplete Purchase Invoices</h6>
                     --}}
                  </div>
                  <div class="col-3 text-right">
                     <i class="feather icon-file-text f-28"></i>
                  </div>
               </div>
            </div>
            <div class="card-footer bg-c-yellow">
               <div class="row align-items-center">
                  <div class="col-12">
                     <p class="text-white m-b-0">Draft Purchase Invoices</p>
                  </div>
                  {{-- 
                  <div class="col-3 text-right">
                     <i class="feather icon-trending-up text-white f-16"></i>
                  </div>
                  --}}
               </div>
            </div>
         </div>
      </a>
   </div>
   <div class="col-xl-3 col-md-6">
      <a href="{{ route('warehouse.dashboard.invoice.complete') }}" class="">
         <div class="card">
            <div class="card-block">
               <div class="row align-items-center">
                  <div class="col-8">
                     <h4 class="text-c-yellow f-w-600">{{ $completedInvoices }}</h4>
                     {{-- 
                     <h6 class="text-muted m-b-0">Complete Invoices</h6>
                     --}}
                  </div>
                  <div class="col-4 text-right">
                     <i class="feather icon-bar-chart f-28"></i>
                  </div>
               </div>
            </div>
            <div class="card-footer bg-c-green ">
               <div class="row align-items-center">
                  <div class="col-12">
                     <p class="text-white m-b-0">Purchase Invoice Final</p>
                  </div>
               </div>
            </div>
         </div>
      </a>
   </div>                                                                                                                                       
   <div class="col-xl-3 col-md-6">
      <a href="{{ route('manager.challan.index') }}" class="">
         <div class="card">
            <div class="card-block">
               <div class="row align-items-center">
                  <div class="col-8">
                     <h4 class="text-c-yellow f-w-600">{{ $weightChallans }}</h4>
                     {{-- 
                     <h6 class="text-muted m-b-0">Complete Invoices</h6>
                     --}}
                  </div>
                  <div class="col-4 text-right">
                     <i class="feather icon-bar-chart f-28"></i>
                  </div>
               </div>
            </div>
            <div class="card-footer bg-c-green ">
               <div class="row align-items-center">
                  <div class="col-12">
                     <p class="text-white m-b-0">Pending Weight Challans</p>
                  </div>
               </div>
            </div>
         </div>
      </a>
   </div>                                                                                                                                   
   <div class="col-xl-3 col-md-6">
      <a href="{{ route('warehouse.dashboard.manager.weightChallanPackets') }}" class="">
         <div class="card">
            <div class="card-block">
               <div class="row align-items-center">
                  <div class="col-8">
                     <h4 class="text-c-yellow f-w-600">{{ $managerWeightChallanPackets }}</h4>
                     {{-- 
                     <h6 class="text-muted m-b-0">Complete Invoices</h6>
                     --}}
                  </div>
                  <div class="col-4 text-right">
                     <i class="feather icon-bar-chart f-28"></i>
                  </div>
               </div>
            </div>
            <div class="card-footer bg-c-green ">
               <div class="row align-items-center">
                  <div class="col-12">
                     <p class="text-white m-b-0">Weight Challan Packets</p>
                  </div>
               </div>
            </div>
         </div>
      </a>
   </div>                                                                                                                            
   <div class="col-xl-3 col-md-6">
      <a href="{{ route('packetProcess.index') }}" class="">
         <div class="card">
            <div class="card-block">
               <div class="row align-items-center">
                  <div class="col-8">
                     <h4 class="text-c-yellow f-w-600">{{ $managerPacketProcessChallans }}</h4>
                     {{-- 
                     <h6 class="text-muted m-b-0">Complete Invoices</h6>
                     --}}
                  </div>
                  <div class="col-4 text-right">
                     <i class="feather icon-bar-chart f-28"></i>
                  </div>
               </div>
            </div>
            <div class="card-footer bg-c-green ">
               <div class="row align-items-center">
                  <div class="col-12">
                     <p class="text-white m-b-0">Packet Process Challans</p>
                  </div>
               </div>
            </div>
         </div>
      </a>
   </div>                                                                                                                          
   <div class="col-xl-3 col-md-6">
      <a href="{{ route('packet.product.index') }}" class="">
         <div class="card">
            <div class="card-block">
               <div class="row align-items-center">
                  <div class="col-8">
                     <h4 class="text-c-yellow f-w-600">{{ $managerFinalPackets }}</h4>
                     {{-- 
                     <h6 class="text-muted m-b-0">Complete Invoices</h6>
                     --}}
                  </div>
                  <div class="col-4 text-right">
                     <i class="feather icon-bar-chart f-28"></i>
                  </div>
               </div>
            </div>
            <div class="card-footer bg-c-green ">
               <div class="row align-items-center">
                  <div class="col-12">
                     <p class="text-white m-b-0">Final Packets</p>
                  </div>
               </div>
            </div>
         </div>
      </a>
   </div>
</div>
@endif
@endsection