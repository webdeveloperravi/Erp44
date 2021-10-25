@extends('layouts.warehouse.app')
@section('css')
<style>
  .alert{
    margin-bottom: 4px;  
    
  } 
</style>
@endsection
@section('content') 
<div class="container-fluid">
   <!--Container Start-->
   <div class="card">
      <div class="card-block">
         <div id="modal"></div>
         <div class="row">
           
            <div class="col-md-3">
               <select class=" selectpicker form-control" data-live-search="true" data-default="Vendor"
                  data-flag="true" id="vendor_id" onchange="change()" name="vendor" autofocus>
                  <option disabled="" value="0" selected="">Select Company</option>
                  @foreach($vendors as $vendor)
                  <option value="{{$vendor->id}}">{{$vendor->company_name}}</option>
                  @endforeach
               </select>
            </div>
            <div class="col-md-2"> 
               <input id="invoice" placeholder="Invoice Number" type="text" class="form-control" name="invoice"  autocomplete="number" >
            </div>
            <div class="col-md-2"> 
               <input class="form-control text-md-right" placeholder="Select Date" type="text" name="date" id="date" autocomplete="off">
            </div>
            <div class="col-2">
               <select class=" selectpicker form-control "  id="product" name="product">
                  <option disabled="" selected="">Select Product</option>
                  @foreach($products  as $product)
                  <option value="{{$product->id}}">{{$product->name}}</option>
                  @endforeach
               </select>
               <!-- Product type Select Entery End -->
            </div>
            <div class="col-md-3 text-right">
               <button class="btn btn-primary ">Print Data</button>
               <button class="btn btn-success">Finish</button>
            </div>
         </div>
      </div>
      <div class="card-block table-border-style invoice-view"> 
       {{-- Place The Invoice Detail Table hear --}}
           
      </div>

   </div>
   <div class="card">
      <!--Card Start-->
      <!--Card header End-->
      <div class="row formalert"> 
      </div>
      <!------Product Purchase Form--------->
      <div class="card-body product_purchase" >
         <!--Card Body Start-->
      </div>
      <!--Card Body End-->
   </div>
   <!--Card End-->
   <div class="card">
      <!--Card Start-->
      <div class="card-header">
         <!--Card header Start-->
         <h4 class="text-left ">Product Purchase View</h4>
      </div>
      <!--Card header End-->
      <div class="card-body">
         <div class="table-responsive product_purchase_list">
            
         </div>
         
         
      </div>
   </div>
   <!--Card End-->
</div>
<!--Container End-->
@section('script')
<script type="text/javascript">
   //product purchase list
   
   function product_purchase_list()
   {
     var url="{{route('product.purchase.list')}}";
     $.get(url , function (data) {
     $(".product_purchase_list").html(data);
     $('.tab_product_purchase_list').DataTable();
   
   });
   
   }

   function change(){
      $('#invoice').trigger('keyup');
   }
   
   $(document).ready(function(){
   
      product_purchase_list(); 
      pro_purchase_form();
   
   
   });
   
   $("#invoice").keyup(function(){ 
      var vendor_id = $("#vendor_id").val();
      var invoice = $("#invoice").val();
      var url = "invoice-view/"+vendor_id+"/"+invoice;

      $.get(url,function(data){
         
         if(data.invoice == "NoData"){
            $(".invoice-view").empty();
         }else{
         $(".invoice-view").html(data.invoice);
         $("#date").attr('value',data.invoiceDate);
         $("#product").val(data.invoiceProduct);
         $("#product").trigger("change");
         }
      });

       
   });

   $('#invoice').focusout(function(){
      $('#invoice').trigger('keyup');
   });

   function edit(id){

      var url = 'invoice-edit/'+id;
      $.get(url,function(data){
         console.log(data);
            $("#modal").html(data.data); 
      });

   }

   function closeModal(){
      // alert("saab");
      $("#modal").empty();
   }

   
      

   $("#product").on("change",function(){     
      // e.preventDefault();
      var vendor_id =  $(this).val();
      var url="product-purchase-pro-cate/"+vendor_id;
      $.get(url,function(data){
         $("select[name='product_category']").html("");
         $("select[name='product_category']").html(data.options);

      });
      
   });
   
   function pro_purchase_form(invoice=""){
   
   var url="{{route('product.purchase.form')}}/";
   
     $.get(url , function (data){
     $(".product_purchase").html(data);
     // $('.tab_product_purchase_form').DataTable();
   
   });
   }
   
   function add_product_purchase(){
     
   var vendor_id = $("#vendor_id").val();
   var invoice = $("#invoice").val();
   var date = $("#date").val();
   var product = $("#product").val();
   var product_cate = $("#product_cate").val();
   var carat = $("#carat").val();
   var piece = $("#piece").val();
   var rate = $("#rate").val();
   var amount = $("#amount").val();
   var token = $("input[name='_token']").val();
   
   // alert("Org : "+vendor_id + "Invoice "+invoice+" date" +date +"product" +product+"Prod Cate "+product_cate+"Carat"+carat +" piece" +piece +"rate "+rate +"total_amount"+total_amount + "Token "+ token);
   
   $.ajax({
     url: "{{route('product.purchase.store')}}",
     method: 'POST',
     data: {
       vendor:vendor_id,
       invoice:invoice,
       date:date,
       product:product,
       product_category:product_cate,
       carat:carat,
       piece:piece,
       rate:rate,
       amount:amount,
      _token:token
     },
     success: function(data) {
      if($.isEmptyObject(data.errors)){
         product_purchase_list(); 
         pro_purchase_form();
         $("#invoice").trigger("keyup");
      }else{
         printErrorMsg(data.errors);
         setTimeout(hideErrors,8000);
      }
         
      }
   });

}

   function hideErrors(){
    $(".formalert").html(''); 
  }

  function printErrorMsg (msg) {
            $(".formalert").html(''); 
            $.each( msg, function( key, value ) {
              $(".formalert").append('<div class="col-md-4"><div class="alert alert-danger print-error-msg">'+
                          '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                          '<i class="icofont icofont-close-line-circled "></i></button>'+
                          value+'</div></div>');
    });
  }
   

   function invoiceDetailUpdate(){
   
   var invoiceId = $("#invoiceEditId").val();
   var editCategory = $("#editCategory").val();
   var carat = $("#carat1").val();
   var piece = $("#piece1").val();
   var rate = $("#rate1").val();
   var amount = $("#amount1").val();
   var token = $("input[name='_token']").val();
    
   
   $.ajax({
     url: "{{route('invoice.detail.update')}}",
     method: 'POST',
     data: { 
       invoiceId:invoiceId,
       productCategory:editCategory, 
       carat:carat,
       piece:piece,
       rate:rate,
       amount:amount,
      _token:token
     },
     success: function(data) { 

        if(data == "success"){
         $("#invoice").trigger("keyup");
         closeModal(); 
        }else{
         editErrorMsg(data.errors);
          setTimeout(hideErrors,8000); 
        } 
        }
   });
   }

   function hideErrors(){
    $(".formalertedit").html(''); 
  }

  function editErrorMsg (msg){
            $(".formalertedit").html(''); 
            $.each( msg, function( key, value ) {
              $(".formalertedit").append('<div class="alert alert-danger print-error-msg">'+
                          '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                          '<i class="icofont icofont-close-line-circled"></i></button>'+
                          value+'</div>');
    });
  }

  

   
</script>
@endsection
@endsection