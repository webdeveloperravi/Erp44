@extends('layouts.warehouse.app')
@section('content')
<div class="page-content page-container" id="page-content">
    <div class=" ">
        <div class="row container d-flex justify-content-center">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-footer p-0" style="background-color: #04a9f5">
            <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">All Invoices</h5>
                  </div>
                    <div class="card-body">
                          
                        {{-- <p class="card-description"> Basic table with card </p> --}}
                        <div class="table-responsive">
                            <table class="table"  id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100">
                                <thead>
                                    <tr>
                                        <th>Invoice Number</th>
                                         <th>Date</th>
                                         <th>Vendor</th>
                                         <th>Product Category</th>
                                         <th>Total Amount</th>
                                      
                                        <th>View</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach($invoices as $invoice)
                                    <tr class="text-center">
                                        <td>{{$invoice->invoice_number}}</td>
                                         <td>{{date_format($invoice->created_at,'d-m-Y')}}</td>  
                                         <td>{{$invoice->vendor->company_name}}</td> 
                                        <td>{{$invoice->invoiceDetail[0]->assign_product->name}}</td> 
                                        <td>{{$invoice->total_amount}}</td> 
                                      
                                        <td><a href="{{route('warehouse.dashboard.invoice',$invoice->id)}}s"><label class="badge badge-danger"><i class="fa fa-eye" aria-hidden="true"></i></label></a></td>
                                    </tr> 
                                    @endforeach
                                </tbody>
                                <tfoot>
                                       <tr>
                                        <th>Invoice Number</th>
                                        <th>Product Category</th>
                                        <th>Vendor</th>
                                        <th>Total Amount</th>
                                        <th>Date</th>
                                        <th>View</th>
                                    </tr>
                                </tfoot>
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
       
   //  window.$('#table_id').DataTable();
     $(document).ready(function(){

     // Setup - add a text input to each footer cell
     $('#example tfoot th').each( function () {
         var title = $(this).text();
         $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
     } );
  
     // DataTable
     var table = $('#example').DataTable({
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
