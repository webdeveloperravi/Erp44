@extends('layouts.warehouse.app')
@section('css')
<style type="text/css">
   input[disabled] {
   color: black;
   }
</style>
@endsection
@section('content') 
@php
    use Carbon\Carbon;
@endphp
<div class="row"> 
   <div class="col">
      <button class="btn btn-dark float-left mb-3" onclick="(window.close())">Back</button>
    </div>
 </div>
@if($product->gin)
<div     class="invoiceView">
   <div class="card">
      <!--Card Start-->  
      <div class="card-footer p-0" style="background-color: #04a9f5">
         <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Gin : {{$product->gin}} </h5>
        </div>
      <div class="card-body">
         <div class="form-group row">
            <div class="offset-md-1 col-sm-6 col-md-5">
               <label for="color">Gin </label>
               <input type="text" class="form-control " disabled value="{{$product->gin}}" >
            </div>
            <div class="col-md-5 col-sm-6">
               <label for="color">Grade</label>
               <input type="text" class="form-control" value="{{$product->grade->grade->grade}}" disabled>
            </div>
         </div>
         <div class="form-group row">
            <div class="offset-md-1 col-sm-6 col-md-5">
               <label for="color">Packet Number </label>
               <input type="text" class="form-control " value="{{ $product->packet->number }}" disabled>
            </div> 
         </div>
         <div class="form-group row">
            <div class="offset-md-1 col-sm-6 col-md-5">
               <label for="color">Length </label>
               <input type="text" class="form-control " value="{{ $product->length }}" disabled>
            </div>
            <div class="col-md-5 col-sm-6">
               <label for="color">Width</label>
               <input type="text" class="form-control" value="{{ $product->width }}"  disabled>
            </div>
         </div>
         <div class="form-group row">
            <div class="offset-md-1 col-sm-6 col-md-5">
               <label for="color">Depth </label>
               <input type="text" class="form-control " value="{{ $product->depth }}" disabled>
            </div>
            <div class="col-md-5 col-sm-6">
               <label for="color">Weight</label>
               <input type="text" class="form-control" value="{{ $product->weight.$mg}}"  disabled>
            </div>
         </div>
         <div class="form-group row">
            <div class="offset-md-1 col-sm-6 col-md-5">
               <label for="color">Product </label>
               <input type="text" class="form-control " value="{{ $product->packet->invoiceDetailGrade->invoiceDetail->product->name }}" disabled>
            </div>
            <div class="col-md-5 col-sm-6">
               <label for="color">Color</label>
               <input type="text" class="form-control" value="{{$product->color->color  }}"  disabled>
            </div>
         </div>
         <div class="form-group row">
            <div class="offset-md-1 col-sm-6 col-md-5">
               <label for="color">Clarity </label>
               <input type="text" class="form-control " value="{{ $product->clarity->clarity }}" disabled>
            </div>
            <div class="col-md-5 col-sm-6">
               <label for="color">Ratti Standard</label>
               <input type="text" class="form-control" value="{{ $product->ratti->rati_standard }}"  disabled>
            </div>
         </div>
         <div class="form-group row">
            <div class="offset-md-1 col-sm-6 col-md-5">
               <label for="color">Rate Profile </label>
               <input type="text" class="form-control " value="{{ $product->rateProfile->name }}" disabled>
            </div>
            <div class="col-md-5 col-sm-6">
               <label for="color">Origin</label>
               <input type="text" class="form-control" value="{{ $product->origin->origin }}"  disabled>
            </div>
         </div>
         <div class="form-group row">
            <div class="offset-md-1 col-sm-6 col-md-5">
               <label for="color">Shape </label>
               <input type="text" class="form-control " value="{{ ucfirst($product->shape->shape) }}" disabled>
            </div>
            <div class="col-md-5 col-sm-6">
               <label for="color">Specie</label>
               <input type="text" class="form-control" value="{{ $product->specie->species }}"  disabled>
            </div>
         </div>
         <div class="form-group row">
            <div class="offset-md-1 col-sm-6 col-md-5">
               <label for="color">SG </label>
               <input type="text" class="form-control " value="{{ $product->sg }}" disabled>
            </div>
            <div class="col-md-5 col-sm-6">
               <label for="color">Ri</label>
               <input type="text" class="form-control" value="{{ $product->ri }}"  disabled>
            </div>
         </div>
         <div class="form-group row">
            <div class="offset-md-1 col-sm-6 col-md-5">
               <label for="color">Treatment</label>
               <input type="text" class="form-control" value="{{ $product->treatment->treatment }}"  disabled>
            </div>
            <div class="col-md-5 col-sm-6">
            </div>
         </div>
      </div>
   </div>
</div>
@else 
<h1 class="text-center">No Product Found</h1>
@endif
@endsection