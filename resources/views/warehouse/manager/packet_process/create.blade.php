@extends('layouts.warehouse.app')
@section('content')
@php
    use Carbon\Carbon; 
@endphp
<div class="col-sm-12">
<div class="card card-border-primary">
<div class="card-block">
    <div class="row">
        <div class="col-sm-6">
            <ul class="list list-unstyled">
                <li>Invoice #: &nbsp;{{ $packet->invoiceDetailGrade->invoiceDetail->invoice->invoice_number }}</li>
                <li>Product : &nbsp;{{ $packet->invoiceDetailGrade->invoiceDetail->assign_product->name }}</li>
                <li>Category : &nbsp;{{ $packet->invoiceDetailGrade->invoiceDetail->product->name }}</li>
                <li>Issued on: <span class="text-semibold">2020-12-09</span></li>
            </ul>
        </div>
        <div class="col-sm-6">
            <ul class="list list-unstyled text-right">
                <li>Grade: &nbsp;{{ $packet->invoiceDetailGrade->grade->grade }}</li>
                <li>Ratti Standard: &nbsp;{{ $packet->ratti->rati_standard }}</li>
                <li>Pieces: &nbsp;{{ $packet->total_piece}}</li>
                {{-- <li>Method: <span class="text-semibold">SWIFT</span></li> --}}
            </ul>
        </div>
    </div>
</div>
</div>

<div class="card card-border-primary">
<div class="card-block">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="row seacrh-header justify-content-center">
                <div class="col-lg-6 col-md-6  ">
                <div class="input-group input-group-button input-group-primary"> 
                    <input type="hidden" name="packetId" id="packetId" value="{{ $packet->id }}"> 
                    <input type="text" name="productNumber" onkeypress="searchProduct()" id="productNumber" class="form-control" placeholder="Gem ID ">
                    <button class="btn btn-primary input-group-addon" id="searchProduct" onclick="searchProduct()">Search</button>
                </div>
                </div> 
                </div>
        
                <div class="row leftProducts"><div class="col-md-8">  
                     
                  
                </div>
                </div>
        </div>
        <div class="col-md-3 leftProductsView"> 
                   
        </div>
    </div>
  

        <div class="row content">
             
                
                   
                
                
                    
        </div>
</div>
</div>
<div class="products_list">

</div> 

</div>
@endsection
@section('script')
 <script>

    $(document).ready(function(){ 
   leftProducts();
   leftProductsView();
   productsList();
});

function addToGemId(productNumber){
   var productNumber = productNumber; 
//    alert(productNumber);
   $("#productNumber").val(productNumber);
   $("#productNumber").focus();
   searchProduct();
}

           
function searchProduct(){
       $("#content").html("");    
       var packetId = $("#packetId").val(); 
       var productNumber = $("#productNumber").val();
       
      $.ajax({
        url : "{{ route('packet.product.create')}}",
        method : "POST",
        data:{
            _token : '{{ csrf_token() }}',
            packetId : packetId, 
            productNumber : productNumber,
        },
        success : function(data){
             $(".content").html(data);
             $("#length").focus();          
        },
      });
     }

     function leftProducts(){ 

    var packetId = $("#packetId").val();
    var url = "{{ route('packetProcess.left.product',['/']) }}/"+packetId;
        $.get(url,function(data){
            $(".leftProducts").html(data);
        });

    } 

     function leftProductsView(){ 

    var packetId = $("#packetId").val();
    var url = "{{ route('packetProcess.left.product_view',['/']) }}/"+packetId;
        $.get(url,function(data){
            $(".leftProductsView").html(data);
        });

    } 

    function productsList(){
        var packetId = $("#packetId").val();
    var url = "{{ route('packetProcess.products_list',['/']) }}/"+packetId;
        $.get(url,function(data){
            $(".products_list").html(data);
        });
    }
    function finishPacketProcessChallan(challanId){ 
    var url = "{{ route('packetProcess.finish',['/']) }}/"+challanId;
        $.get(url,function(data){
            // $(".products_list").html(data);
        });
    }

     
function closeForm()
{
  $("#new_color").hide();
  $(".stock_edit_div").hide();
 
} 


    </script>
@endsection
