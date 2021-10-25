
@extends('layouts.warehouse.app')
@section('content') 
<style>
  tfoot input {
      width: 100%;
      padding: 3px;
      box-sizing: border-box;
  }
</style>
<div class="invoiceView">
  <div class="card"><!--Card Start--> 
    <div class="card-footer p-0" style="background-color: #04a9f5">
      <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Process Packets</h5>
  </div>
<div class="card-body">
  @if ($packetProcessChallans->count() !== 0)
  <div class="table-responsive">
    <table class="table" id="table_id2" style="width:100">
  <thead>
  <tr>
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
   
    @if(\App\Helpers\CheckPermission::instance()->viewAction('view-final-product-packets'))
    @foreach ($packetProcessChallans as $packetProcessChallan) 
  
      <tr class="text-center">
        <td>{{ $loop->iteration }}</td>
      <td><label>{{ $packetProcessChallan->packet->invoiceDetailGrade->invoiceDetail->invoice->invoice_number }}</label></td>
      <td><label>{{ $packetProcessChallan->packet->number }}</label></td>
      <td><label>{{$packetProcessChallan->packet->invoiceDetailGrade->grade->grade }}</label></td>
      <td><label>{{ $packetProcessChallan->packet->total_piece }}</label></td>
      <td><label>{{ $packetProcessChallan->packet->ratti->rati_standard }}</label> </td>
      		
      @if(\App\Helpers\CheckPermission::instance()->viewAction('view-final-products'))
      <td> <a href="{{route('packet.products',$packetProcessChallan->packet->id)}}" class="btn btn-sm btn-info">View Products</a></td> 
      @endif
      </tr>  
   @endforeach
   @endif
  </tbody>
  <tfoot>
    <tr>
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

  <h3 class="text-center text-danger">Empty</h3>
  @endif
</div>
</div><!--Card End-->

<!--Modal Part-->
<div class="modal-part"></div>


</div>


@endsection
@section('script') 
<script>
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
@endsection 