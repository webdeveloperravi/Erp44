@extends('layouts.store.app')
@section('content')
{{-- <livewire:sale-challan /> --}}
<div id="app">
 <sale-order-prepare v-bind:sale-order="{{ $saleOrder }}" v-bind:stores="{{ $stores }}"
  route-get-accounts="{{route('saleOrderPrepare.getAccounts')}}"
  route-save-gins="{{route('saleOrderPrepare.saveGins')}}"
  route-get-all-details="{{route('saleOrderPrepare.getAllDetails')}}"
  route-get-all-details="{{route('saleOrderPrepare.getLeftQtyToAdd')}}"
  route-delete-product="{{route('saleOrderPrepare.deleteProduct')}}"
  route-save="{{route('saleOrderPrepare.save')}}"
  route-refresh-sale-order="{{route('saleOrderPrepare.refreshSaleOrder')}}"
  ></sale-order-prepare>
</div>
@endsection