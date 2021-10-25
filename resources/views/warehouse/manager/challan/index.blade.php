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
        <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">{{ $heading ?? "Error" }}</h5>
        </div> 
    <div class="card-body"> 
@if (count($challans)) 
     
        <div class="table-responsive">
            <table class="table" id="table_id2" style="width:100">
        <thead>
            <tr>
                <th>From</th>
                <th>Date</th> 
                <th>CH-No.</th>
                <th>Product</th>
                <th>Grade</th>    
                <th>Qty.</th>  
                <th>Weight Process</th>  
                <th>Packaging Process</th>  
                <th>Returned</th>  
                <th>Action</th>  
            </tr>
        </thead>
        <tbody>
            @foreach ($challans as $challan)   
            <tr class="text-center">
                <td>{{$challan->super->name}}</td>
                <td>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $challan->created_at)->isoFormat('DD-MM-YYYY') }}</td> 
                {{-- <td>{{$challan->invoiceDetailGrade->invoiceDetail->invoice->invoice_number}}</td>   --}}
                <td>{{$challan->challan_number}}</td> 
                <td>{{$challan->invoiceDetailGrade->invoiceDetail->product->name}}</td> 
                <td>{{$challan->invoiceDetailGrade->grade->alias}}</td> 
                {{-- <td>{{$challan->invoiceDetailGrade->carat.$mg}}</td>  --}}
                <td>{{$challan->invoiceDetailGrade->piece}}</td>
                @php
                    $weightStatus = $challan->weightComplete($challan->invoiceDetailGrade->id);
                    $packagingStatus = $challan->packetsComplete($challan->invoiceDetailGrade->id);
                @endphp
    <td>
        @if (!$weightStatus)
        <i class="fa fa-check text-success"></i> 
        @else
        <i class="fa fa-times text-danger"></i> 
        @endif
    </td> 
    <td>
        @if (!$packagingStatus)
        <i class="fa fa-check text-success"></i> 
        @else
        <i class="fa fa-times text-danger"></i> 
        @endif
    </td>
    <td> 
        @if (!$weightStatus && !$packagingStatus)
          @if($challan->returnedToSuper($challan->invoiceDetailGrade->id))
          <i class="fa fa-check text-success"></i> 
          @else
          <i class="fa fa-times text-danger"></i> 
          @endif
        @else 
          <i class="fa fa-times text-danger"></i> 
        @endif 
    </td> 
    <td>
        @if ($challan->accept_challan == 1)
        @if ($weightStatus)
        <a href="{{ route('manager.weight.create',$challan->id) }}" class="btn btn-info btn-sm b-none">Start Weight</a>   
        @elseif($packagingStatus)
        <a href="{{ route('manager.weight.create',$challan->id) }}" class="btn btn-info btn-sm b-none">Start Packaging</a>   
        @elseif(!$challan->returnedToSuper($challan->invoiceDetailGrade->id))
        <a href="{{ route('manager.weight.create',$challan->id) }}" class="btn btn-info btn-sm b-none">Return Packets</a>   
        @else
        <a href="{{ route('manager.weight.create',$challan->id) }}" class="btn btn-info btn-sm b-none">View</a>   
        @endif 
        @else 
        <button class="btn btn-dark btn-sm b-none" onclick="previewChallan({{ $challan->id }})">Preview</button>
        @endif
        
    </td> 
    </tr> 
            @endforeach
        </tbody>
    </table>
</div>
@else 
<h2 class="text-center"><i class="fa fa-inbox"></i>&nbsp; No Weight Challans Left</h2> 
@endif
</div>
</div> 
<div id="previewView"></div>
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

               $('input', this.footer() ).on( 'keyup change clear', function () {
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

   function previewChallan(id){
       $.get("{{ Route('manager.challan.preview',['/']) }}/"+id,function(data){
              $("#previewView").html(data);      
       });
   }

   function acceptChallan(id){
       $.get("{{ Route('manager.challan.accept',['/']) }}/"+id,function(data){
              $("#previewView").html("");
              location.reload();   
       });
   }
    </script>
 
@endsection