 
            @if(count($orderDetails))
           <div class="table-responsive">
              <table class="table" id="example" style="width:100">
                 <thead>
                    <tr>
                    <th>Sr.</th> 
                    <th>Product</th>
                    <th>Grade</th>
                    <th>Ratti Standard</th> 
                    <th>Qty.</th> 
                    <th>Action</th> 
                    </tr>
                 </thead>
                 <tbody>
                    @foreach ($orderDetails as $detail)
                    <tr class="text-center">
                        <td>{{$loop->iteration}}</td> 
                        <td>{{$detail->product->name ?? " "}}</td>  
                        <td>{{$detail->grade->grade ?? " "}}</td>  
                        <td>{{$detail->ratti->rati_standard . "+" }}</td>  
                        <td>{{$detail->quantity ?? ""}}</td>  
                        <td><Button class="btn btn-danger btn-sm" onclick="deleteDetail({{ $detail->id }})">Delete</Button></td>  
                    </tr>
                    @endforeach
                 </tbody>
              </table>
           </div>
           <div class="card-footer" >
            <button class="" onclick="placeOrder2()">Place Order</button>
        </div>  
        @endif  
    