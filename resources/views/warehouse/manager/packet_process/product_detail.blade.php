<div class="table-responsive">
    @php
        // dump($product->grade->invoicedetail->product->name);
        // dump($product->grade->grade->grade);
        // dump($product->grade->invoicedetail->invoice->invoice_number);
    @endphp
    <table class="table">
    <thead>
        <tr> 
            <th>Product No.</th>
            <th>Weight</th>
            <th>Product</th>
            <th>Grade</th>
            <th>Inovoice No.</th>
            <th>Action</th> 
        </tr>
    </thead>
    <tbody>
     <tr id="myTable">
        {{-- <td ><input type="text" onkeyup="productChange(this.value)" name="product_id" class="form-control" id='product_id'></td> --}}
        <td></td>
        <input type="hidden" name="product_id" id="product_id" value="{{ $product->id }}">
        <td><input type="number" step=".01" id="weight" name="weight" class="form-control" placeholder="enter weight"></td> 
         <td><button class="btn btn-primary" onclick="saveWeight()">Next</button></td>
     </tr>
     <tr>
         <td></td>
         <td></td>
         <td></td>
         <td></td>
     </tr>
    </tbody>
</table>

</div>