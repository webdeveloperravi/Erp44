@if($packetProcessingChallans->count() !== 0)
<div class="table-responsive ">
    <table class="table table-bordered table-hover ">
        <thead>
            <tr class="table-active">
                <th>S.No</th>
                <th>Invoice</th>
                <th>Number</th>
                <th>Grade</th>
                <th>Pieces</th>
                <th>Ratti Standard</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($packetProcessingChallans as $packetProcessingChallan)
            <tr class="text-center">
                <td>{{ $loop->iteration }}</td>
              <td><label>{{ $packetProcessingChallan->packet->invoiceDetailGrade->invoiceDetail->invoice->invoice_number }}</label></td>
              <td><label>{{ $packetProcessingChallan->packet->number }}</label></td>
              <td><label>{{ $packetProcessingChallan->packet->invoiceDetailGrade->grade->grade }}</label></td>
              <td><label>{{ $packetProcessingChallan->packet->total_piece }}</label></td>
              <td><label>{{ $packetProcessingChallan->packet->ratti->rati_standard }}</label></td> 
              <td>
                  <button class="btn btn-primary" onclick="receivePacketProcess2({{ $packetProcessingChallan->id }})">Accept</button>
              </td>
              </tr>  
            @endforeach
            
        </tbody>
    </table>
    </div>
    @else 
    <h3 class="text-center text-danger">No Pending Packet Process Challans For Accept</h3>
@endif
    <script>
         function receivePacketProcess2(packetProcessingChallan){
            var url = "{{ route('authorization.receive.packet.process.2',['/']) }}/"+packetProcessingChallan;
            $.get(url,function(data){
                receivePacketProcess();
            });
        }
    </script>