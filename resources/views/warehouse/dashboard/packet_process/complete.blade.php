@extends('layouts.warehouse.app')
@section('content') 
<!--  @php 
    use Carbon\Carbon;
 @endphp  -->
<div class="page-content page-container" id="page-content">
    <div class=" ">
        <div class="row container d-flex justify-content-center">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                           <h4>All Invoice Packet Process</h4>
                        <!-- {{-- <p class="card-description"> Basic table with card </p> --}} -->
                        <div class="table-responsive">
                            <table class="table"  id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100">
                                <thead>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Invoice Number</th>
                                        <th>Packet Number</th>
                                        <th>Total Piece</th>
                                        <th>Ratti</th>
                                        <th>View</th>
                                    </tr>
                                </thead>
                                <tbody>
                                     @foreach ($packets as $packet)
                                    <tr class="text-center">
                                      <td>{{$loop->iteration}}</td>
                                      <td>{{$packet->invoiceDetailGrade->invoiceDetail->invoice->invoice_number}}</td>

                                        <td>{{$packet->number}}</td> 
                                        <td>{{$packet->total_piece}}</td>
                                        <td>{{$packet->ratti->rati_standard}}</td>
                                         <td><a href="{{route('warehouse.dashboard.manager.packet.process.detail',$packet->id)}}"><label class="badge badge-danger"><i class="fa fa-eye" aria-hidden="true"></i></label></a></td>
                                    </tr>
                                    @endforeach 	
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 
@endsection
@section('script')
    <script>
        $(document).ready(function() {
    $('#example').DataTable();
} );
    </script>
@endsection




