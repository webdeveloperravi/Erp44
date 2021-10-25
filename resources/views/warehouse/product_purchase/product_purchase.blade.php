 <div class="table-responsive ">
  
<table class="table tab_product_purchase_form" >
<thead>
<tr> 
<th>Select Product</th>
<th>Weight</th>
<th>Unit</th>
<th>Piece</th>
<th>Rate</th>
<th>Total</th>
<th>Action</th>
</tr>
</thead>
<tbody>  
<tr>
<form class="product_purchase_form"  onsubmit="add_product_purchase()">
  @csrf  
<td>
<select class=" selectpicker form-control "  data-live-search="true" data-default="Product Type"
data-flag="true" id="product_cate" name="product_category"> 
</select><!-- Product type Select Entery End -->
</td>
<td><input type="number" inputmode=""  class="form-control"  name="carat" onfocusout="amountRefresh();clearValue(event)" id="carat"></td>
<td> 
  <select class=" selectpicker form-control" id="unit_id" name="unit_id">
  @foreach ($units as $unit)
  <option value="{{ $unit->id }}" {{ $unit->name == 'Carat' ? 'selected' : "" }}>{{ $unit->name }}</option> 
  @endforeach
  </select>
</td>
<td><input type="number" class="form-control" name="piece" id="piece" onfocusout="clearValue(event)"></td>
<td><input type="number" class="form-control" name='rate' onfocusout="amountRefresh();clearValue(event)"  id="rate"></td>
<td><input type="text" class="form-control" placeholder="Rate * Carat" id="amount" name="amount"></td>
<td>
<button type="submit" class="btn btn-warning btn-sm" id="btn-add-more" onclick="add_product_purchase()">Add More</button>
  
</td>
</form>
</tr>
</tbody>
</table>
</div>

<script type="text/javascript">
//   $(document).ready(function(){
//   $('[data-toggle="tooltip"]').tooltip();
// });




$(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
        
 
$(document).ready(function() {
    $('[data-toggle="popover"]').popover({
        html: true,
        content: function() {
            return $('#primary-popover-content').html();
        }
    });
});




$("#date").on('mouseover',function(){
$(this).datepicker({
dateFormat: "dd/mm/yy",
defaultDate: '01/04/2020',
changeMonth: true,
changeYear: true,
minDate: 0,
});
});
 

// calculate rate from rate into carat
function amountRefresh(event){ 
var rate=$("#rate").val();
var carat=$("#carat").val();
var total_amount=carat*rate;
$("#amount").val(total_amount);
$("#amount").val(total_amount);
$("#amount").prop("disabled", true);
$("#amount").css("font-weight", "bold");
}


$("#rate").focusout(function(event){
// event.preventDefault();
// var rate=$("#rate").val();
// var carat=$("#carat").val();
// var total_amount=carat*rate;
// $("#amount").val(total_amount);
// $("#amount").val(total_amount);
// $("#amount").prop("disabled", true);
// $("#amount").css("font-weight", "bold");
});

// to work only numeric value anytext filed
// $("input[type='text']").keypress(function (e) {
//if the letter is not digit then display error and don't type anything
// if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
//display error message
// $("#errmsg").html("Digits Only").show().fadeOut("slow");
//  return false;
// }
// });

//to store product purchase record ........

// $("#btn-add-more").click(function(){
// var url='{{route('product.purchase.store')}}';
// var form_data=$(".product_purchase_form").serialize();

// alert(form_data);
// return false;
// $.ajax({
// url : url,
// type : "Post",
// data : form_data,
// success : function(res)
// {
// $(".success_msg").show();
// $(".success_msg").html(res["success"]);
//      $(function(){
//         $(".success_msg").delay(10000).fadeOut();
//          });
//    product_purchase_list(); 
//    pro_purchase_form();
// },
// error:function(errorData)
// {
// var messages=errorData.responseJSON["message"];
// alert("errors");
// $("#error_msg").show();
// $("#res").empty();
// for (var i =0; i<messages.length; i++) {
// $("#res").append("<ul><li>"+messages[i]+"</li></ul>");
// }
// $(function(){
// $("#error_msg").delay(10000).fadeOut();
// });
// }

// });
  

// });
function clearValue(event){
    val = event.target.value;
    if(val == 0 ){
      event.target.value="";
    } 
}

</script>