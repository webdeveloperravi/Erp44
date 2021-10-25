<style>
    tfoot input {
        width: 100%;
        padding: 3px;
        box-sizing: border-box;
    }
</style>
<div class="card">
   <div class="card-footer p-2" style="background-color: #04a9f5">
      <h5 class="text-white m-b-0 text-left d-inline" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Vendor List</h5>
   </div>
   <div class="card-body">
      <div class="table-responsive">
         <table class="table" id="table_id2" style="width:100">
            <thead>
               <tr>
                  <th>Sr.No.</th>
                  <th>Company Name</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Action</th>
               </tr>
            </thead>
            <tbody>
               @foreach ($vendors as $vendor)
               <tr class="text-center">
                  <td>{{$loop->iteration}}</td>
                  <td>{{$vendor->company_name}}</td>
                  <td>{{$vendor->name}}</td>
                  <td>{{$vendor->email}}</td>
                  <td>{{$vendor->phone}}</td>
                  <td><a href="{{route('warehouse.vendor.show',$vendor->id)}}" class="btn btn-primary btn-sm ">View</a>
                      @if($vendor->status==1)
                     <button class="btn btn-success btn-sm m-l-10" onclick="status('{{$vendor->id}}')">Enable</button> 
                      @else
                     <button class="btn btn-danger btn-sm m-l-10" onclick="status('{{$vendor->id}}')">Disable</button> 

                      @endif
                   </td>
               </tr>
               @endforeach
            </tbody>
            <tfoot>
               <tr>
                  <th>Sr.No.</th>
                  <th>Company Name</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Action</th>
               </tr>
            </tfoot>
         </table>
      </div>
   </div>
</div>
 <script>
     //  window.$('#table_id').DataTable();
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

