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
   <div class="card-footer p-2" style="background-color: #04a9f5">
      <h5 class="text-white m-b-0 text-left d-inline" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;"> Issued Packet Process</h5> 
   </div>

    <div class="card-body"> 
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
                <th>Packet Process</th> 
                <th>Return to Super</th> 
                <th>Status</th> 
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
            <td>
                @if ($packet->packedIssuedToManager($packet->id))
                @if (!$packet->packetChallans->packetProcessStatus($packet->id))
                <i class="fa fa-check text-success"></i>
                @else
                <i class="fa fa-times text-danger"></i> 
                @endif
                @else
                <i class="fa fa-times text-danger"></i> 
                @endif
            </td>
            <td>
                @if ($packet->packedIssuedToManager($packet->id))
                @if ($packet->packetChallans->status == 'return-to-super')
                <i class="fa fa-check text-success"></i>  
                @else
                <i class="fa fa-times text-danger"></i> 
                @endif
                @else
                <i class="fa fa-times text-danger"></i> 
                @endif
            </td>
            @if ($packet->packetChallans->status == 'return-to-super')
            <td> <button class="btn btn-success">Returned To Super</button></td>
            @else
            <td> <button class="btn btn-success">Issued To Manager</button></td>
            @endif 
            </tr>  
         @endforeach
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
    </div>
</div>
 


 
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


        function issueToManager(packetId){ 
            var url = "{{ route('packet.issueToManager',['/'])}}/"+packetId; 
                $.get(url,function(data){ 
            $(".modal-part").html(data);
            });
   }

   function closeModal(){
    $(".modal-part").empty();
   }

   function issueToManagerSave(){ 
     url = "{{ route('packet.issueToManager.store') }}"
     form_data = $("#issueToManagerSave").serialize();
     $.ajax({
       method : "post",
       data : form_data,
       url : url,
       success:function(data){
          if(data == "success"){
            $(".modal-part").empty(); 
            location.reload();
          }
          if(data.error){  
            $("#date").after('<span class="text-strong text-danger">' +data.error+ '</span>'); 
            setTimeout(hideErrors,5000);
          } 
          } 

          });
   }
    </script>
@endsection 