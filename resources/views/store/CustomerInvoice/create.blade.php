@extends('layouts.store.app')
@section('content') 
<div id="app">
  <customer-invoice  
  route-find-customer="{{route('customerInvoice.findCustomer')}}"
  route-create-customer="{{route('customerInvoice.createCustomer')}}"
  route-save-customer="{{route('customerInvoice.saveCustomer')}}"
  route-save-gins="{{route('customerInvoice.saveGins')}}"
  route-payment-create="{{route('customerInvoice.paymentCreate')}}"
  route-get-all-details="{{route('customerInvoice.getAllDetails')}}"
  route-get-payment-accounts="{{route('customerInvoice.getPaymentAccounts')}}"
  route-payment-save="{{route('customerInvoice.paymentSave')}}"
  route-place-order="{{route('customerInvoice.placeOrder')}}"
  v-bind:payment-modes="{{ $paymentModes }}"
  ></customer-invoice>
</div>
 
@endsection