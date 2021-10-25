@extends('layouts.store.app')
@section('content') 
<div id="app">   
    <opening-stock 
    route-save-gins="{{ route('store.openingStock.saveGins') }}" 
    route-get-all-details="{{ route('openingStock.getAllDetails') }}" 
    route-delete-product="{{ route('openingStock.deleteProduct',['/']) }}"  
    route-opening-stock-save="{{ route('store.openingStock.save') }}" 
    account-name='{{ $accountName }}' 
    ></opening-stock>
</div>
@endsection 