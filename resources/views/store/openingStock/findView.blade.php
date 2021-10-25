 <div class="card">
     
    <div class="card-footer p-0" style="background-color: #04a9f5">
        <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Search Result </h5>
    
    </div>
    <div class="card-body">
      
        <div class="table-responsive">
            @if (!empty($ledger)) 
           <table class="table" style="width:100">
           <thead>
                    <tr>
                   <td>UID</td>
                   <th>Date</th>
                   <th>OS-Number</th>
                   <th>Total Stock</th>
                   <th>Left Stock</th>
                   <th>Total Amount</th>
                   <th>Left Amount</th>
                   <th>Print</th>
                   <th>Action</th>
                        </tr>
                     </thead>
                     <tbody> 
                      <tr class="text-center">
                         <td>{{$ledger->id }}</td>
                           <td>{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $ledger->created_at)->isoFormat('DD-MM-YY') }}</td> 
                           <td>{{$ledger->voucher_number}}</td>
                           <td>{{$ledger->qty_total}}</td>
                           <td>{{$ledger->left_qty}}</td> 
                           <td>{{$ledger->total_amount}}</td> 
                           <td>{{ $ledger->left_amount ?? 0}}</td>
                           <td> <div class="dropdown-inverse dropdown open">
                            <button class="btn btn-inverse dropdown-toggle waves-effect waves-light " type="button" id="dropdown-7" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Print</button>
                            <div class="dropdown-menu" aria-labelledby="dropdown-7" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                            <a target="_blank" class="dropdown-item waves-light waves-effect" href="{{ route('openingStock.printReport',['challanId'=>$ledger->id,'type'=> 'scan']) }}">Scan Sort</a>
                            <a target="_blank" class="dropdown-item waves-light waves-effect" href="{{ route('openingStock.printReport',['challanId'=>$ledger->id,'type'=> 'pgr']) }}">PGR Sort</a> 
                            </div>
                            </div></td>
                           <td><a class="btn btn-sm btn-inverse" href="{{ route('store.openingStock.view',$ledger->id) }}">View Stock</a></td> 
                         </tr> 
                    
                      </tbody> 
                    </table>
             @else      
          <div class="card-body">
           <h2 class="text-center"><i class="fa fa-inbox"></i>&nbsp; Empty</h2>
          </div>
          @endif
       </div>
     </div> 
     
 </div>