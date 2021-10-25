<style>
    tfoot input {
        width: 100%;
        padding: 3px;
        box-sizing: border-box;
    }
</style>
    <div class="card-body">
       <div class="table-responsive">
          <table class="table" id="table_id2" style="width:100">
             <thead>
                <tr> 
                   <th>Name</th>
                   {{-- <th>Store Name</th> --}}
                   <th>Manager Role</th>
                   <th>Email</th>
                   <th>Mobile</th>
                   <th>Action</th> 
                </tr>
             </thead>
             <tbody>
                 @foreach ($accounts as $account)
                 <tr class="text-center"> 
                     <td>{{$account->name ?? ""}}</td>
                     {{-- <td>{{$account->store->company_name ?? ""}}</td> --}}
                     <td>{{$account->managerRole->name ?? ""}}</td>
                     <td>{{$account->email ?? ""}}</td>
                     <td>{{$account->phone ?? ""}}</td> 
                    <td><a  href="{{ route('subStore.manager.view',$account->id) }}" class="btn btn-warning p-1 mr-1" >View</a></td> 
                  </tr>
                @endforeach
             </tbody>
             <tfoot>
                <tr> 
                   <th>Name</th>
                   <th>Store Name</th>
                    <th>Manager Role</th>
                   <th>Email</th>
                   <th>Mobile</th> 
                </tr>
             </tfoot>
          </table>
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

