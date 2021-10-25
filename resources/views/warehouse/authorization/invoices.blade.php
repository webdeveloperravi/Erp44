@if ($invoices->count() !== 0)
<div class="table-responsive ">
    <table class="table table-bordered table-hover ">
        <thead>
            <tr class="table-active">
                <th>S.No</th>
                <th>Invoice Number</th>
                <th>Vendor</th>
                <th>Received By</th>
                <th>Amount</th> 
                <th>Date</th> 
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoices as $invoice)
            <tr class="text-center">
                <td>{{$loop->iteration}}</td>
                <td>{{$invoice->invoice_number}}</td>  
                <td>{{$invoice->vendor->company_name}}</td> 
                <td>{{$invoice->user->name}}</td> 
                <td>{{$invoice->total_amount}}</td>  
                 <td>{{ Carbon\Carbon::createFromDate($invoice->date)->format('d-m-Y') }}</td>
                <td><button class="btn btn-primary" onclick="invoice({{ $invoice->id }})">Preview</button></td>
            </tr> 
            @endforeach
            
        </tbody>
    </table>
    </div>
    <div id="invoiceView"></div>
    @else 
    <h3 class="text-center text-danger">No Pending Invoices For Authorization</h3>
@endif
    <script>
        function invoice(invoiceId){
            var url = "{{ route('authorization.invoice',['/']) }}/"+invoiceId;
            $.get(url,function(data){
                $("#invoiceView").html(data);
            });
        }
    </script>