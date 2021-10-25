@extends('layouts.store.app')
@section('content')
{{-- <livewire:sale-challan /> --}}
<div id="app">
  <sale-return v-bind:stores="{{ $stores }}" 
  route-save-gins="{{route('saleReturn.saveGins')}}"
  route-get-all-details="{{route('saleReturn.getAllDetails')}}"
  route-delete-product="{{route('saleReturn.deleteProduct')}}"
  route-save="{{route('saleReturn.save')}}"></sale-return>
</div>
@endsection