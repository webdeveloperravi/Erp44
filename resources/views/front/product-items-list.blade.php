@extends('layouts.front.app')

@section('page_title') {{ request()->product_name }} @endsection
@section('page_description') account page description @endsection

@section('content')
    <livewire:product-items-list />
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
@endsection
