 
  <div class="md-modal modal-lg md-effect-1 md-show editModal" id="modal-1" style="width: 70%; max-width:1300px">
    <div class="md-content">
        <div class="row">
            <div class="col-md-3"> 
               <select class=" selectpicker form-control" data-live-search="true" data-default="Vendor"
                  data-flag="true" id="vendor_id" onchange="change()" name="vendor" disabled> 
                  
                  <option value="{{$invoice->vendor_id}}" selected>{{$invoice->vendor->company_name}}</option>
                 
               </select> 
               
            </div>
            <div class="col-md-2">  
               <input id="invoice" value="{{$invoice->invoice_number ?? ""}}" placeholder="Invoice Number" type="number" class="form-control" name="invoice" readonly autocomplete="number" autofocus  onfocusout="clearValue(event)">
              
               
            </div>
            <div class="col-md-3">  
               <input class="form-control text-md-right"  type="text" name="date" id="date" value="{{ now() }}" autocomplete="off" placeholder="Choose Date" disabled>
              
               {{-- <input type="text" id="datepicker" name="date" class="hasDatepicker"> --}}
               {{-- <input id="date" type="date"  class="form-control" name="date" " autofocus="" > --}}
            </div>
            <div class="col-4"> 
               <select class=" selectpicker form-control "  id="product" name="product" disabled>
                  <option  selected disabled>Select Product Category</option>
                 
                  {{-- <option value="{{$invoice->invoiceDetail[0]->product->id}}">{{$invoice->product->name}}</option> --}}
                  
               </select>
               
               <!-- Product type Select Entery End -->
            </div> 
         </div> 
     
        <div class="table-responsive">
            <table class="table">
            <thead>
            <tr class="table-active">
            <th>SN.</th>
            <th>Product</th>
            <th>Weight/Unit</th>
            <th>Weight/mg</th>
            <th>Piece</th>
            <th>Rate</th>
            <th>Amount</th> 
            </tr>
            </thead>
            <tbody class="text-center">
                @if (empty($invoice))
                @else
                @foreach ($invoice->invoiceDetail as $detail)
                <tr class="text-center"> 
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $detail->product->name }}</td>
                    <td>{{ $detail->weightUnit($detail->carat,$detail->unit_id) }}</td>
                    <td>{{ $detail->carat . " mg" }}</td>
                    {{-- <td>{{ app\Helpers\Helper::weightTOCarat($detail->carat) ." ct"}}</td> --}}
                    <td>{{ $detail->piece . " /P" }}</td>
                    <td>{{"Rs.".$detail->rate }}</td>
                    <td>{{ $detail->amount }}</td>  
                    
                  
                      
                     
                       
                </tr>
                @endforeach
                @endif
                <thead>
                <tr class="table-active"> 
                    <td>Total : </td>
                    <td>{{ $invoice->totalItems($invoice->id)." Items" }}</td>
                    <td>{{ app\Helpers\Helper::weightToCarat($invoice->totalWeight($invoice->id))." Ct."  }}</td>
                    <td>{{ $invoice->totalWeight($invoice->id)." mg"  }}</td>
                    <td>{{ $invoice->totalPiece($invoice->id)." /p"  }}</td>
                    <td></td>
                    <td>Total : {{ $invoice->total_amount }}</td>
                    <td  colspan="3"></td>
                </tr>
                </thead>
            </tbody>
            </table>
            <button class="btn btn-danger float-right" onclick="closeModal()">Close</button>
            <button class="btn btn-primary float-right mr-5" onclick="InvoiceAuthorize({{ $invoice->id }})">Authorize</button>
        </div>
    </div>

  </div>
  <div class="md-overlay"></div>
  <script>
      function closeModal(){
         $("#invoiceView").html("");
      }
      function InvoiceAuthorize(invoiceId){
          var url = "{{ route('authorization.invoice.authorize',['/']) }}/"+invoiceId;
          $.get(url,function(data){
            closeModal();
            invoices();
          });
      }
  </script>
 

