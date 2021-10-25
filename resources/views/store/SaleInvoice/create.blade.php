@extends('layouts.store.app')
@section('content')
{{-- <livewire:receive-challan /> --}}
<div id="app">
  <sale-invoice v-bind:stores="{{ $stores }}"
    route-get-accounts="{{route('saleInvoice.getAccounts')}}"
  route-save-gins="{{route('saleInvoice.saveGins')}}"
  route-get-all-details="{{route('saleInvoice.getAllDetails')}}"
  route-delete-product="{{route('saleInvoice.deleteProduct')}}"
  route-save="{{route('saleInvoice.save')}}"
  ></sale-invoice>
</div>
@endsection