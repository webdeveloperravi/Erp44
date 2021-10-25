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
                           <h4>All Invoice Weight Completed</h4>
                        <!-- {{-- <p class="card-description"> Basic table with card </p> --}} -->
                        <div class="table-responsive">
                            <table class="table"  id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100">
                                <thead>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Invoice Number</th>
                                        <th>Challan Number</th>
                                        <th>Issue Date</th>

                                        <th>Complete Date</th>
                                        <th>View</th>
                                    </tr>
                                </thead>
                                <tbody>
                                     @foreach ($challans as $challan)
                                    <tr class="text-center">
                                      <td>{{$loop->iteration}}</td>
                                      <td>{{$challan->invoiceDetailGrade->invoiceDetail->invoice->invoice_number}}</td>

                                        <td>{{$challan->challan_number}}</td> 
                                        <td>{{$challan->created_at}}</td> 
                                        @if($challan->status=='weight_complete')
                                        <td>{{$challan->updated_at}}</td>
                                        @else
                                        <td>Pending-work</td>
                                        @endif
                                         <td><a href="{{route('manager.weight.create',$challan->id)}}"><label class="badge badge-danger"><i class="fa fa-eye" aria-hidden="true"></i></label></a></td>
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




