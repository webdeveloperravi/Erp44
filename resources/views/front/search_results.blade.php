@extends('layouts.front.app')

@section('page_title')
    Search Results for - {{ request()->all()['query'] }}
@endsection
@section('page_description') Catalogue @endsection

@section('content')

    <livewire:product-items-list />
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
@endsection
