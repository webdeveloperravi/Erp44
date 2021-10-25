<table class="table table-bordered " id="table_id2">
    <thead>
        <tr>
          <th>Sr.No.</th>
          <th>Name</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
    </thead>
    <tbody>
      @if($type_list->isEmpty())
     {{-- <td colspan="5"><h2 style="color:red; text-align: center;">No Record Found</h2></td> --}}
      @else
        @foreach($type_list as $tl_key => $tl_val)
        
        <tr>
           <td>{{$loop->iteration}}</td>
        <td>{{strtoupper($tl_val->name)}}</td>
      @if($tl_val->status==0)
       <td class="text-warning">In-active</td>
        @else
        <td class ="text-success">Active</td>
        @endif
        <td>
          <button class="btn btn-warning btn-sm p-1" onclick="changeStatus({{$tl_val->id}},'{{$tl_val->status}}')"  style="width:60px;">{{($tl_val->status==1?"In-active":"Active")}}</button>
    <button class="btn btn-sm btn-primary p-1 " onclick="editAddressType({{$tl_val->id}},'{{$tl_val->name}}')" style="width:60px;"> edit</button>
 
        </td>
         
         
      </tr>

        @endforeach
      @endif
    </tbody>
    <tfoot>
      <tr>
        <th>Sr.No.</th>
        <th>Name</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </tfoot>
  </table>  
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