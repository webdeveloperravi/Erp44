@extends('layouts.store.app')
@section('content')
 <h1 class="text-cneter">Dashboard {{ auth('store')->user()->name ?? "" }}</h1>
@endsection