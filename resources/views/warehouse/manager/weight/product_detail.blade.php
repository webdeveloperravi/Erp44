<div class="table-responsive mb-3"  style="border: 1px solid #d2d2dc;">
<table class="table mb-0">
<thead>
    <tr class="table-active"> 
        <th>Product No.</th>
        <th>Weight</th>
        <th>Product</th>
        <th>Grade</th>
        <th>Inovoice No.</th>
        <th>Action</th> 
    </tr>
</thead>
<tbody>
    <tr id="myTable" class="text-center"> 
    <td>{{ $product->id }}</td>
    <input type="hidden" name="product_id" id="product_id" value="{{ $product->id }}">
    <td><input type="number" step=".01" id="weight" name="weight" class="form-control" onkeypress="javascript: if(event.keyCode == 13) saveWeight();" onfocusout="clearValue(event)" placeholder="enter weight"  autofocus></td>
        <td>{{ $product->grade->invoicedetail->product->name }}</td>
        <td>{{ $product->grade->grade->grade }}</td>
        <td>{{ $product->grade->invoicedetail->invoice->invoice_number }}</td>
        <td><button class="btn btn-primary" onclick="saveWeight()">Next</button></td>
    </tr> 
</tbody>
</table>

</div>
    <script>
    	function clearValue(event){
    val = event.target.value;
    if(val == 0 ){
      event.target.value="";
    } 
  }
  </script>