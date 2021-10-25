<div class="card-block p-0">
    @if (!empty($ledgerDetails))
    <div class="table-responsive ">
      <table class="table table-bordered table-hover ">
          <thead>
                 <tr class="table-active">
                     <th>Sr.No</th>
                     <th>Gin</th>
                     <th>Product Category</th>
                     <th>Product</th>
                     <th>Grade</th>
                     <th>Ratti</th>
                     <th>Price</th>
                     {{-- <th>Action</th> --}}
                 </tr>
             </thead>
             <tbody> 
              @foreach($ledgerDetails as $detail)
               <tr class="text-center">
                <td>{{'#'.$loop->iteration}}</td>
                <td>{{$detail->productStock->gin}}</td>
                <td>{{$detail->productStock->grade->invoiceDetail->assign_product->name}}</td>
                <td>{{$detail->productStock->packet->invoiceDetailGrade->invoiceDetail->product->name}}</td>
                <td>{{$detail->productStock->grade->grade->grade}}</td>
                <td>{{$detail->productStock->ratti->rati_standard}}</td> 
                <td>{{ $detail->amount }}</td>
               </tr>
               @endforeach
             </tbody>
         </table>
     </div>
      @endif
</div>  