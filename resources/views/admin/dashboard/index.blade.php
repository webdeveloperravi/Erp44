@extends('layouts.admin.app')
@section('title', 'Dasboard')
@section('meta_description','Dashboard Description')
@section('content')
<div class="container"> 
<h2 class="text-center mb-5">Welcome {{ auth('admin')->user()->email ?? "" }}</h2>
 
</div>

@endsection