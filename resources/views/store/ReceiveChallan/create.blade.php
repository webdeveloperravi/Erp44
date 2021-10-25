@extends('layouts.store.app')
@section('content')
{{-- <livewire:receive-challan /> --}}
<div id="app">
  <receive-challan v-bind:stores="{{ $stores }}"
  route-get-accounts="{{route('receiveChallan.getAccounts')}}"
  route-save-gins="{{route('receiveChallan.saveGins')}}"
  route-get-all-details="{{route('receiveChallan.getAllDetails')}}"
  route-delete-product="{{route('receiveChallan.deleteProduct')}}"
  route-save="{{route('receiveChallan.save')}}"
  ></receive-challan>
</div>
@endsection