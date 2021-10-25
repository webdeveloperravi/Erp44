@extends('layouts.store.app')
@section('content') 
<div id="app">
  <sale-challan v-bind:stores="{{ $stores }}"
    route-get-accounts="{{route('saleChallan.getAccounts')}}"
  route-save-gins="{{route('saleChallan.saveGins')}}"
  route-get-all-details="{{route('saleChallan.getAllDetails')}}"
  route-delete-product="{{route('saleChallan.deleteProduct')}}"
  route-save="{{route('saleChallan.save')}}"
  ></sale-challan>
</div>
@endsection