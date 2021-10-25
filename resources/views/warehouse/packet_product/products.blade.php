@extends('layouts.warehouse.app')
@section('content') 
<div class="row"> 
    <div class="col">
       <button class="btn btn-dark float-left mb-3" onclick="(window.location.replace('{{url()->previous()  }}'))">Back</button>
     </div>
  </div>
 
        <div class="card">
            <div class="card-footer p-0" style="background-color: #04a9f5">
                <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Packet Products </h5>
                </div>
            <div class="card-body">
                    
                {{-- <p class="card-description"> Basic table with card </p> --}}
                <div class="table-responsive">
                    <table class="table"  id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100">
                        <thead>
                            <tr>
                                <th>UID</th> 
                                <th>Gin</th>
                                <th>Weight</th>
                                <th>Action</th> 
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr class="text-center">
                                <td>{{$product->id}}</td> 
                                <td>{{$product->gin}}</td>
                                <td>{{$product->weight}}mg</td>
                                <td><a class="btn btn-sm btn-primary" target="_blank" href="{{route('packet.product.view',$product->id)}}">View</a></td>
                            </tr> 
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div> 
@endsection
@section('script')
    <script>
    
    </script>
@endsection
