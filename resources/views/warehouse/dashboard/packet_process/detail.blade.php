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
                           <h4>All Invoice Packet Process Detail</h4>
                        <!-- {{-- <p class="card-description"> Basic table with card </p> --}} -->
                        <div class="table-responsive">
                            <table class="table"  id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100">
                                <thead>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>UID Number</th>
                                        <th>Product</th>
                                        <th>Grade</th>
                                        <th>Weight</th>
                                        <th>View</th>
                                    </tr>
                                </thead>
                                <tbody>
                                     @foreach ($packetProcessDetail as $packet_detail)
                                    <tr class="text-center">
                                      <td>{{$loop->iteration}}</td>
                                      <td>{{$packet_detail->number}}</td>
                                      <td>{{$packet_detail->packet->invoiceDetailGrade->invoiceDetail->product->name}}</td>
                                      <td>{{$packet_detail->packet->invoiceDetailGrade->grade->grade}}</td>
                                      <td>{{$packet_detail->weight}}</td>
                                      <td>action</td>

                                       
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




