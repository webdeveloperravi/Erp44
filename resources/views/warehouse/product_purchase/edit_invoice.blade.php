@php
    use App\Helpers\Helper;
@endphp
<div class="modal fade show" id="large-Modal" tabindex="-1" role="dialog" style="z-index: 1050; display: block;">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="margin-top: 200px">
    <div class="modal-content">
     
    <div class="modal-body p-0" > 
      <div class="card-footer p-0" style="background-color: #04a9f5">
        <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Edit Invoice Detail </h5>
        </div>     
<div class="table-responsive ">
  <div class="formalertedit">
      
  </div>
    
  <table class="table table-bordered table-hover tab_product_purchase_form" >
  <thead>
  <tr> 
  <th>Product</th>
  <th>Weight</th>
  <th>UNit</th>
  <th>Piece</th>
  <th>Rate</th>
  <th>Total</th> 
  </tr>
  </thead>
  <tbody>  
  <tr>
    @php
    // dd($product_categories);
@endphp
  <form class="product_purchase_form">
    @csrf 
  <td>
      <input type="hidden" value="{{ $invoice->id }}" name="invoiceEditId" id="invoiceEditId">
  <select class=" selectpicker form-control "  data-live-search="true" data-default="Product Type"
  data-flag="true" id="editCategory" name="editCategory">

  <option>Select Product</option>

  @if(!empty($product_categories))
    @foreach($product_categories as $key => $value)
      <option {{ $invoice->product_cate_id == $key ? "selected" : ""}} value="{{ $key }}">{{$value }}</option>
    @endforeach
  @endif
  </td>
  {{-- <td><input type="number" value="{{ $invoice->carat }}" class="form-control" onfocusout="amountRefresh2()"  name="carat" id="carat1"></td> --}}
  <td><input type="number" value="{{$invoice->unitConversionBack( $invoice->carat,$invoice->unit_id) }}" class="form-control" onfocusout="amountRefresh2()"  name="carat" id="carat1"></td>
  <td> 
    <select class=" selectpicker form-control " id="unit_id1" name="unit_id">
      @foreach ($units as $unit)
      <option value="{{ $unit->id }}" {{ $unit->id == $invoice->unit_id ? "selected" : ""}}>{{$unit->name}}</option>
      @endforeach
    </select>
  </td>
  <td><input type="number" value="{{ $invoice->piece }}" class="form-control"  name="piece" id="piece1" onfocusout="clearValue(event)"></td>
  <td><input type="number" value="{{ $invoice->rate }}" class="form-control" onfocusout="amountRefresh2()" name='rate' id="rate1"  onfocusout="clearValue(event)"></td>
  <td><input type="text" value="{{ $invoice->amount }}" disabled class="form-control" placeholder="Rate * Carat" id="amount1" name="amount"  onfocusout="clearValue(event)"></td> 
  </form>
  </tr>
  </tbody>
  </table>
  </div>
    </div>
    <div class="modal-footer">
    <button type="button" class="btn btn-danger waves-effect " onclick="closeModal()" data-dismiss="modal">Cancel</button>
    <button type="button" class="btn btn-success" onclick="invoiceDetailUpdate()">Update</button> 
    </div>
    </div>
    </div>
    </div>
    <div class="md-overlay" style="opacity: 1; visibility:visible"></div>
    <script>
function amountRefresh2(event){ 
var rate=$("#rate1").val();
var carat=$("#carat1").val();
var total_amount=carat*rate;
$("#amount1").val(total_amount);
$("#amount1").val(total_amount);
$("#amount1").prop("disabled", true);
$("#amount1").css("font-weight", "bold");
}
// function clearValue(event){
//     val = event.target.value;
//     if(val == 0 ){
//       event.target.value="";
//     } 
// }
function invoiceDetailUpdate(){
   
   var invoiceId = $("#invoiceEditId").val();
   var editCategory = $("#editCategory").val();
   var carat = $("#carat1").val();
   var unit_id = $("#unit_id1").val();
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
       unit_id:unit_id,
       piece:piece,
       rate:rate,
       amount:amount,
      _token:token
     },
     success: function(data) { 

        if(data.errors){ 
            $("#btn-add-more").attr('disabled',false);
            $.each(data.errors,function(field_name,error){ 
                        $(document).find('[name='+field_name+']').addClass('input-border-red');
         }); 
         }else{
         $("#invoice").trigger("focusout");
         closeModal();   
         notify('Successfully Updated','success'); 
      }
    },
   });
   }
 
    </script>
   
 