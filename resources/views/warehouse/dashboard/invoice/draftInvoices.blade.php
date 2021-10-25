@extends('layouts.warehouse.app') 
@section('content')  
<style>
    tfoot input {
        width: 100%;
        padding: 3px;
        box-sizing: border-box;
    }
</style>   
<div class="card">
    <div class="card-footer p-0" style="background-color: #04a9f5">
        <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">{{ $heading ?? "All invoices" }}</h5>
        </div> 
    <div class="card-body"> 
                  
        <div class="table-responsive">
            <table class="table" id="table_id2" style="width:100">
        <thead>
            <tr>
                <th>Sr.</th>
                <th>Date</th>
                <th>No.</th>
                <th>Vendor</th>
                <th>Qty.</th>
                <th>Amt.</th>  
                <th>Action</th>  
            </tr>
        </thead>
        <tbody>
            @foreach($invoices as $invoice)
            <tr class="text-center">
                <td>{{$invoice->id}}</td>
                <td>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $invoice->created_at)->isoFormat('DD-MM-YYYY') }}</td> 
                <td>{{$invoice->invoice_number}}</td>  
                <td>{{$invoice->vendor->company_name}}</td> 
                <td>{{$invoice->totalItems($invoice->id)}}</td> 
                <td>{{$invoice->totalAmount($invoice->id)}}</td>  
                <td><a href="{{route('warehouse.dashboard.invoice',$invoice->id)}}"><label class="badge badge-danger"><i class="fa fa-eye" aria-hidden="true"></i></label></a></td>
            </tr> 
            @endforeach
        </tbody>
    </table>
</div>
                    </div>
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
