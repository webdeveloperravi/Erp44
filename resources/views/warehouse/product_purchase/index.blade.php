@extends('layouts.warehouse.app')
 
@section('content') 
{{-- <div class="container-fluid" id="element"> --}}

   <div class="card">
      <div class="card-block">
         <div id="modal"></div>
         <div class="row"> 
            <div class="col-md-3">
               @if (isset($invoice))
               <select class="js-example-basic-single  form-control" data-live-search="true" data-default="Vendor"
                  data-flag="true" id="vendor_id" name="vendor" disabled> 
                  <option value="{{$invoice->vendor_id}}" selected>{{$invoice->vendor->company_name}}</option>
               </select>
               @else
               <select class="js-example-basic-single  form-control" data-live-search="true" data-default="Vendor"
                  data-flag="true" id="vendor_id" onchange="change()" name="vendor">
                  <option disabled="" value="" selected="">Select Vendor</option> 
                  @foreach($vendors as $vendor)
                  <option value="{{$vendor->id}}">{{$vendor->company_name}}</option>
                  @endforeach
               </select>
               @endif
            </div>
            <div class="col-md-2"> 
               @if (isset($invoice))
               <input id="invoice" value="{{$invoice->invoice_number ?? ""}}" placeholder="Invoice Number" type="number" class="form-control" name="invoice" readonly autocomplete="number"   onfocusout="clearValue(event)">
               @else 
               <input id="invoice" value="{{$invoice_number ?? ""}}" placeholder="Invoice Number" type="number" class="form-control" name="invoice"  autocomplete="number"   onfocusout="clearValue(event)">
               @endif
               
            </div>
            <div class="col-md-3"> 
               @if (isset($invoice))
               <input class="form-control text-md-right"  type="text" name="date" id="date" value="{{ now() }}" autocomplete="off" placeholder="Choose Date" disabled>
               @else 
               <input class="form-control text-md-right"  type="text" name="date" id="date" value="{{ now() }}" autocomplete="off" placeholder="Choose Date">
               @endif
               {{-- <input type="text" id="datepicker" name="date" class="hasDatepicker"> --}}
               {{-- <input id="date" type="date"  class="form-control" name="date" " ="" > --}}
            </div>
            <div class="col-4">
               @if (isset($invoice))
               <select class=" selectpicker form-control "  id="product" name="product" disabled>
                  <option  selected>Select Product Category</option>
                  @foreach($products  as $product)
                  <option value="{{$product->id}}">{{$product->name}}</option>
                  @endforeach
               </select>
               @else
               <select class=" selectpicker form-control "  id="product" name="product">
                  <option selected>Select Product Category</option>
                  @foreach($products  as $product)
                  <option value="{{$product->id}}">{{$product->name}}</option>
                  @endforeach
               </select>
               @endif 
            </div> 
         </div>
      </div>
      <div class="row formalert"> 
      </div>
      @if(\App\Helpers\CheckPermission::instance()->viewAction('invoice-product-add')) 
      <div class="card-body product_purchase pt-1" >

         <!--Card Body Start-->

      </div>
     
      <div class="row justify-content-center">
         <div style="display: none"  class="loader-block complete-loader " >
           <svg id="loader2" viewBox="0 0 100 100" style="">
           <circle id="circle-loader2" cx="50" cy="50" r="45"></circle>
           </svg>
           </div>  
       <div class="row pb-3" id="successMsg" style="display: none">
         <div class="col-sm-12 col-md-12 col-xl-12"> 
            <h3 class="text-primary text-center">Successfull Added ! </h3> 
            </div>
       </div>
       
       <div class="row pb-3" id="updateMsg" style="display: none">
         <div class="col-sm-12 col-md-12 col-xl-12"> 
            <h3 class="text-success text-center">Successfull Updated ! </h3> 
            </div>
       </div>
       
       <div class="row pb-3" id="deleteMsg" style="display: none">
         <div class="col-sm-12 col-md-12 col-xl-12"> 
            <h3 class="text-danger text-center">Successfull Deleted ! </h3> 
            </div>
       </div>
      </div>
      @endif
      @if(\App\Helpers\CheckPermission::instance()->viewAction('invoice-product-view'))
      <div class="card-block table-border-style invoice-view">  
      </div>
      @endif
   </div> 
   <div id="gradeSortView">

   </div>
</div>

 
@section('script')
<script type="text/javascript">

   


   $('#date').datepicker({ 

    startDate: new Date()

   }); 

   function change(){
      $('#invoice').trigger('focusout');
   }
   
   $(document).ready(function(){
      
      pro_purchase_form();
   }); 

   $(document).ready(function(){
       var a = '{{ $invoice->id ?? "" }}';
       
       if(a > 0){ 
        $("#invoice").trigger('focusout');
       } 

   });

   function clearValue(event){
    val = event.target.value;
    if(val == 0 ){
      event.target.value="";
    } 
}

   
   $("#invoice").keyup(function(){ 
      if (event.keyCode === 13) {
      var vendor_id = $("#vendor_id").val();
      var invoice = $("#invoice").val();
      var url = "{{ route('invoice.view',['/','/']) }}/"+vendor_id+"/"+invoice;
      // var url = "invoice-view/"+vendor_id+"/"+invoice;
      
      $.get(url,function(data){
         if(data.invoice == "NoData"){
            $(".invoice-view").empty();
            $(".product_purchase").show();
         }else{
         $(".invoice-view").html(data.invoice);
         $("#date").attr('value',data.invoiceDate);
         $("#product").val(data.invoiceProduct);
         $("#product").trigger("change");
         if(data.invoiceComplete == 1){
            $(".product_purchase").hide();
            $("#completeButton").hide();
            $(".editInvoice").hide();
            $(".deleteInvoice").hide();
            $("#gradeNowButton").hide();
            $("#draftButton").hide();
            

         }else{
            $(".product_purchase").show();
            $("#completeButton").show();
            $(".editInvoice").show();
            $(".deleteInvoice").show();
            $("#gradeNowButton").show();
            $("#draftButton").show();
         }
         }
      });
      }
   });

   $('#invoice').focusout(function(){
      
      if($("#invoice").val() > 0){
         var vendor_id = $("#vendor_id").val();
      var invoice = $("#invoice").val();
      // var url = "invoice-view/"+vendor_id+"/"+invoice;
      var url = "{{ route('invoice.view',['/','/']) }}/"+vendor_id+"/"+invoice;
       

      $.get(url,function(data){ 
         if(data.msg == "not_authorized"){
            swal("You Are Not Authorized to View This Invoice.")
            .then((value) => {
               location.href = "{{ route('product-purchase') }}";
            }); 
         }
         if(data.invoice == "NoData"){
            $(".invoice-view").empty();
            $(".product_purchase").show();
         }else{
         $(".invoice-view").html(data.invoice);
         $("#date").attr('value',data.invoiceDate);
         $("#product").val(data.invoiceProduct);
         $("#product").trigger("change");
         if(data.invoiceComplete == 1){
            $(".product_purchase").hide();
            $("#completeButton").hide();
            $(".editInvoice").hide();
            $(".deleteInvoice").hide();
            $("#gradeNowButton").hide();
            $("#draftButton").hide();
            

         }else{
            $(".product_purchase").show();
            $("#completeButton").show();
            $(".editInvoice").show();
            $(".deleteInvoice").show();
            $("#gradeNowButton").show();
            $("#draftButton").show();
         }
         }
      });
      }
      
   });

   function edit(id){
      
      var url = "{{ route('invoice.detail.edit',['/']) }}/"+id;
     
      // var url = 'invoice-edit/'+id;
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
      var productId =  $(this).val();
      var vendorId =  $("#vendor_id").val();
      var invoiceNumber = $("#invoice").val(); 
      var url = "{{ route('product.purchase.pro.cate',['/','/','/']) }}/"+productId+"/"+vendorId+"/"+invoiceNumber;
      // var url="product-purchase-pro-cate/"+productId+'/'+vendorId+'/'+invoiceNumber;
      // alert(url);
      $.get(url,function(data){
         $("select[name='product_category']").html("");
         $("select[name='product_category']").html(data.options);

      });
      
   });
   
   function pro_purchase_form(invoice=""){
   
   var url="{{route('product.purchase.form')}}/";
   
     $.get(url , function (data){
     $(".product_purchase").html(data);
   
   });
   }
   
   function add_product_purchase(){
    
   $("#btn-add-more").attr('disabled',true);
   var vendor_id = $("#vendor_id").val();
   var invoice = $("#invoice").val();
   var date = $("#date").val();
   var product = $("#product").val();
   var product_cate = $("#product_cate").val();
   var carat = $("#carat").val();
   var unit_id = $("#unit_id").val();
   var piece = $("#piece").val();
   var rate = $("#rate").val();
   var amount = $("#amount").val();
   var token = $("input[name='_token']").val();
   
   // alert("Org : "+vendor_id + "Invoice "+invoice+" date" +date +"product" +product+"Prod Cate "+product_cate+"Carat"+carat +" piece" +piece +"rate "+rate +"total_amount"+total_amount + "Token "+ token);
   
   $.ajax({ url: "{{route('product.purchase.store')}}",
     method: 'POST',
     data: {
       vendor:vendor_id,
       invoice:invoice,
       date:date,
       product:product,
       product_category:product_cate,
       carat:carat,
       unit_id:unit_id,
       piece:piece,
       rate:rate,
       amount:amount,
      _token:token
     },
     beforeSend:function(){
         // $(".product_purchase").hide();
         //$(".complete-loader").show();
       },
     success: function(data){
      if(data.errors){ 
            $("#btn-add-more").attr('disabled',false);
            $.each(data.errors,function(field_name,error){ 
                        $(document).find('[name='+field_name+']').addClass('input-border-red');
            }); 
            setTimeout(hideErrors,5000); 
      }else{
         pro_purchase_form();
         $("#invoice").trigger("focusout"); 
         $("#successMsg").show();
         setTimeout(function(){
            $("#successMsg").hide();
         },3000);
         notify('Successfully Saved','success');
      }
      }
   });
}
 
 
   
 
 

 
  

  

   
</script>
@endsection
@endsection