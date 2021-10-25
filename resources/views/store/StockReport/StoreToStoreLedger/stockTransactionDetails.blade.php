<div class="card" id="form">
    <!--Header ---->
    <div class="card-footer p-0" style="background-color: #04a9f5">
      <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Transaction Voucher No.{{ $ledger->voucher_number }}</h5>
     </div>
@if (count($ledger->ledgerDetails))
<div class="table-responsive">
    <table class="table"  id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100">
        <thead>
            <tr class="text-center">
                <th>Sr.</th>
                <th>Gin</th>
                <th>Product</th>
                <th>Grade</th> 
                <th>Ratti</th> 
            </tr>
        </thead>
        <tbody> 
            @foreach($ledger->ledgerDetails as $detail)
            <tr class="text-center">
                <td>{{$loop->iteration}}</td> 
                <td>{{ $detail->productStock->gin }}</td>  
                <td>{{ $detail->productStock->product->name }}</td>  
                <td>{{ $detail->productStock->productGrade->grade }}</td>  
                <td>{{ $detail->productStock->ratti->rati_standard }}</td> 
                {{-- <td></td> --}}
            </tr> 
            @endforeach
        </tbody>
    </table>
</div>
@else
<h2 class="text-center"><i class="fa fa-inbox"></i>&nbsp; No Transactions</h2>
@endif
</div> 