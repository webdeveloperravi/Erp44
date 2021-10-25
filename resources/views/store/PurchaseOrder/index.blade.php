 
@extends('layouts.store.app')
@section('content')

<div class="row"> 
   <div class="col">
      <button class="btn btn-dark float-right mb-3" onclick="createPurchaseOrder()">Create Order</button>
    </div>
</div>
 <div id="success"></div>
<div id="create"> </div> 
<div id="all"> </div> 
@section('script')
<script type="text/javascript">

$(document).ready(function(){
    allPurchaseOrders();
});

function createPurchaseOrder(){

    var url ="{{route('purchaseorder.create')}}";
    $.get(url,function(data){
        $("#create").html(data);
    });
}


function getGrades(productId)
{
    var url ="{{route('purchaseorder.getGrades',['/'])}}/"+productId;
    $.get(url,function(data){
        $("#grades").html(data);
    });
}

function allPurchaseOrders(){

var url ="{{route('purchaseorder.allorders')}}";
$.get(url,function(data){
    $("#all").html(data);
});
}




</script>
@endsection
@endsection