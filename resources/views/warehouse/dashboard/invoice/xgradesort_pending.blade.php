@extends('layouts.warehouse.app')
@section('content')
<div class="page-content page-container" id="page-content">
    <div class=" ">
        <div class="row container d-flex justify-content-center">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                           <h4>All invoices</h4>
                        {{-- <p class="card-description"> Basic table with card </p> --}}
                        <div class="table-responsive">
                            <table class="table"  id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100">
                                <thead>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Invoice Number</th>
                                        <th>Product Category</th>
                                        <th>Vendor</th>
                                        <th>Total Amount</th>
                                        <th>Date</th>
                                        {{-- <th>Finish</th> --}}
                                        <th>View</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach($invoices as $invoice)
                                    <tr class="text-center">
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$invoice->invoice_number}}</td> 
                                        <td>{{$invoice->invoiceDetail[0]->assign_product->name}}</td> 
                                        <td>{{$invoice->vendor->company_name}}</td> 
                                        <td>{{$invoice->total_amount}}</td> 
                                        <td>{{date_format($invoice->created_at,'d/m/Y')}}</td>  
                                        <td><a href="{{route('warehouse.dashboard.invoice',$invoice->id)}}"><label class="badge badge-danger"><i class="fa fa-eye" aria-hidden="true"></i></label></a></td>
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
