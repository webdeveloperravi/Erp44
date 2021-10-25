@extends('layouts.warehouse.app')
@section('content') 
 @php use Carbon\Carbon; 
 @endphp 
<div class="col-sm-12">
    <div class="card card-border-primary">
    <div class="card-header">
    <h5>From : {{ $challan->super->name }} ({{ $challan->super->role->name }}) </h5> 
    <div class="task-list-table float-right">
        <p class="task-due"><strong> Due : </strong><strong class="label label-primary">{{ Carbon::parse($challan->created_at)->diffForHumans()}}</strong></p>
       </div>
    </div>
    <div class="card-block">
    <div class="row">
    <div class="col-sm-6">
    <ul class="list list-unstyled">
    <li>Invoice #: &nbsp;{{ $challan->invoiceDetailGrade->invoiceDetail->invoice->invoice_number }}</li>
    <li>Product : &nbsp;{{ $challan->invoiceDetailGrade->invoiceDetail->product->name }}</li>
    <li>Category : &nbsp;{{ $challan->invoiceDetailGrade->invoiceDetail->assign_product->name }}</li>
    <li>Issued on: <span class="text-semibold">{{ Carbon::createFromDate($challan->date)->format('d-m-Y') }}</span></li>
    </ul>
    </div>
    <div class="col-sm-6">
    <ul class="list list-unstyled text-right">
        <li>Grade: &nbsp;{{ $challan->invoiceDetailGrade->grade->grade }}</li>
        <li>Weight: &nbsp;{{ $challan->invoiceDetailGrade->carat.$mg }}</li>
        <li>Pieces: &nbsp;{{ $challan->invoiceDetailGrade->piece }}</li> 
    </ul>
    </div>
    </div>
    </div> 
    </div>
    </div>
    @if($challan->status == 'weight_complete')
    @else
    @if(\App\Helpers\CheckPermission::instance()->viewAction('create-product-weight'))
    <div class="col-sm-12">
        <div class="card card-border-primary"> 
        <div class="card-block"> 
            <div class="row" id="gemSearch">
                <div class="col-lg-4 offset-lg-4 offset-sm-3 col-sm-6 offset-sm-1 col-xs-12">
                <div class="input-group input-group-button input-group-primary"> 
                    <input type="hidden" name="gradeId" id="gradeId" value="{{ $challan->invoiceDetailGrade->id}}">
                    <input type="hidden" name="challanId" id="challanId" value="{{$challan->id}}">
                    <input  type="text" name="productNumber" onkeypress="searchProduct()" id='productNumber' class="form-control" placeholder="Gem ID ">
                    <button class="btn btn-primary input-group-addon" id="searchProduct" onclick="searchProduct()">Search</button>
                </div>
                </div>
                </div>
                <div class="row leftProducts">
                   
                </div>
                <div class="card-body content p-0"> 
                   
                </div> 
               
        </div>
        </div>
    </div>
    @endif
   @endif
   <div class="col-sm-12">
    <div class="card card-border-primary"> 
    
        <div class="card-body index"> 

        </div>
   
    </div>
   </div>

   <div class="col-sm-12"> 
    
        <div  id="finishWeightMakePackets"> 

        </div>
    
   </div>
 
@endsection
@section('script')
<script>
   setTimeout(() => {
       index();
   }, 3000);
    
$(document).ready(function(){ 
   leftProducts();
  //  index();
  //  makePacketsView("{{ $challan->invoiceDetailGrade }}");
});

function addToGemId(productNumber){
   var productNumber = productNumber; 
//    alert(productNumber);
   $("#productNumber").val(productNumber);
   $("#productNumber").focus();
   searchProduct();



}

   function leftProducts(){
    //    alert("nand");
    var gradeId = '{{ $challan->invoiceDetailGrade->id }}';
    var url = "{{ route('manager.weight.left.product',['/']) }}/"+gradeId;
        $.get(url,function(data){  
            $(".leftProducts").html(data.data);
            if(data.productsCount == '0'){
               $("#gemSearch").hide();
            }else{
                $("#gemSearch").show(); 
            }
        });
    } 
   
  function searchProduct(){
       $("#content").html("");    
       var productNumber = $("#productNumber").val();
       var challanId = $("#challanId").val();
       var gradeId = $("#gradeId").val();
       
      $.ajax({
        url : "{{ route('manager.weight.product')}}",
        method : "POST",
        data:{
            _token : '{{ csrf_token() }}',
            productNumber : productNumber,
            challanId : challanId,
            gradeId : gradeId,
        },
        success : function(data){
             $(".content").html(data);   
             $("#weight").focus();

        },
      });
     }

     function saveWeight(){
        var url = "{{ route('manager.weight.store')}}";
        var weight = $("#weight").val();
        var productId = $("#product_id").val(); 
        $.ajax({
          url : url,
          method:"POST",
          data:{
            _token : "{{ csrf_token() }}",
            weight:weight,
            productId:productId,
          },
          success:function(data){
               index();
               $(".content").html("");  
               $("#productNumber").val("");
               leftProducts();

          }
        });
     }

     function index(){ 
        var url = "{{ route('manager.weight.index')}}";
        var productNumber = $("#productNumber").val(); 
        var gradeId = "{{ $challan->invoiceDetailGrade->id}}";
        $.ajax({
          url : url,
          method:"POST",
          data:{
            _token : "{{ csrf_token() }}",
            productNumber:productNumber,
            gradeId:gradeId,
          },
          success:function(data){
            //  if(data == 'no'){
            //     $(".index").html("");
            //  }else{
             $(".index").html(data);
            //  }
              
          }
        });
     } 

    function showEditModal(product_id){
        var url = "{{ route('manager.weight.edit',['/']) }}/"+product_id;
        $.get(url,function(data){
            $(".animation-model").html(data);
        });
    }

    function closeEditModal(){
        $(".md-modal").removeClass('md-show');
    }

    function finishWeight(gradeId){ 
      var url = "{{ route('manager.weight.finish',['/']) }}/"+gradeId;
      $.get(url,function(data){ 
         makePacketsView(gradeId);
         $(".weight_edit_button").hide();
         $(".start_packaging_button").hide(); 
         
        //  $("#finishWeightMakePackets").html(data);
        //  location.href = "#finishWeightMakePackets";
      });
    }

    function makePacketsView(gradeId){  
        var url = "{{ route('manager.challan.packet.all',['/']) }}/"+gradeId;
         $("#finishWeightMakePackets").LoadingOverlay("show"); 
        $.get(url,function(data){
         
         $("#finishWeightMakePackets").html(data);
         $("#finishWeightMakePackets").LoadingOverlay("hide"); 
         location.href = "#finishWeightMakePackets";   
        });
    }

</script>
@endsection