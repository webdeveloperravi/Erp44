<style>
    tfoot input {
        width: 100%;
        padding: 3px;
        box-sizing: border-box;
    }
</style>
<div class="card">
<div class="card-footer p-0" style="background-color: #04a9f5">
    <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Packet Process</h5>
   </div>
<div class="card-body">
@if($packetProcessingChallans->count() !== 0)
<div class="table-responsive">
    <table class="table table table-striped table-bordered dt-responsive nowrap" id="table_id2" style="width:100">
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
        <tfoot>
            <tr class="table-active">
                <th>S.No</th>
                <th>Invoice</th>
                <th>Number</th>
                <th>Grade</th>
                <th>Pieces</th>
                <th>Ratti Standard</th>
                <th>Action</th>
            </tr>
        </tfoot>
    </table>
    </div>
    @else 
    <h2 class="text-center"><i class="fa fa-inbox"></i>&nbsp; No Pending Packet Process Challans For Accept</h2> 
@endif
</div>
</div>
    <script>
         function receivePacketProcess2(packetProcessingChallan){
            swal({
                title: "Are you sure?",
                text: "You Receive a Packet After Packet Process",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
                .then((willDelete) => {
                if (willDelete) {
                    var url = "{{ route('authorization.receive.packet.process.2',['/']) }}/"+packetProcessingChallan;
                    $.get(url,function(data){
                        receivePacketProcess();
                    });
                    swal("Packet Accepted", {
                    icon: "success",
                    });
                } else {
                    // swal("Your imaginary file is safe!");
                }
            });


           
        }

        $(document).ready(function(){

// Setup - add a text input to each footer cell
$('#table_id2 tfoot th').each( function () {
    var title = $(this).text();
    $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
} );

// DataTable
var table = $('#table_id2').DataTable({
    initComplete: function () {
        // Apply the search
        this.api().columns().every( function () {
            var that = this;

            $( 'input', this.footer() ).on( 'keyup change clear', function () {
                if ( that.search() !== this.value ) {
                    that
                        .search( this.value )
                        .draw();
                }
            } );
        } );
    }
});
});
    </script>