 <div class="card"> 
    <div class="card-footer p-0" style="background-color: #04a9f5">
       <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">All Received Order</h5>
    </div>
 <div class="card-body">
      @if($orders->isNotEmpty())
       <div class="table-responsive">
          <table class="table" id="example" style="width:100">
             <thead>
                <tr>
                <th>Po-No.</th>
                <th>Date</th>
                <th>Account</th>
               <th>Action</th> 
                </tr>
             </thead>
             <tbody>
                @foreach ($orders as $order)
                <tr class="text-center">
             <!--    <td>#{{$loop->iteration}}</td> -->
                <td>#{{$order->po_number}}</td>  
             <!--    <td>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $order->created_at)->isoFormat('Do MMMM,YYYY')}}</td>  -->
             <td>{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $order->created_at)->isoFormat('DD-MM-YYYY') }}</td> 
                <td>{{$order->buyerStoreName->name ?? '' }}</td>
                <td>{{$order->getTotalPurchaseOrderQty($order->id) }}</td>
                    <td><a href="{{route('purchaseorder.order.detail',$order->id)}}" class="btn btn-sm btn-info ">View</Button></td>  
                </tr>
                @endforeach
             </tbody>
          </table>
       </div>
        @else
        <h2 class="text-center"><i class="fa fa-inbox"></i>&nbsp; Empty</h2>
        @endif 
        </div>
 </div>


