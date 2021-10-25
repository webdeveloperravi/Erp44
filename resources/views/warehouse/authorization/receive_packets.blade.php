@if($packets->count() !== 0)
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
            @foreach ($packets as $packet)
            <tr class="text-center">
                <td>{{ $loop->iteration }}</td>
              <td><label>{{ $packet->invoiceDetailGrade->invoiceDetail->invoice->invoice_number }}</label></td>
              <td><label>{{ $packet->number }}</label></td>
              <td><label>{{$packet->invoiceDetailGrade->grade->grade }}</label></td>
              <td><label>{{ $packet->total_piece }}</label></td>
              <td><label>{{ $packet->ratti->rati_standard }}</label></td>
              <td><button class="btn btn-primary" onclick="receivePacket({{ $packet->id }})">Accept</button></td> 
            @endforeach
            
        </tbody>
    </table>
    </div>
    @else 
    <h3 class="text-center text-danger">No Pending Weight Challans For Accept</h3>
@endif
    <script>
        function receivePacket(packetId){
            var url = "{{ route('authorization.receive.packet',['/']) }}/"+packetId;
            $.get(url,function(data){
                receivePackets();
            });
        }
    </script>