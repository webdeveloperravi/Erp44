<style>
  tfoot input {
      width: 100%;
      padding: 3px;
      box-sizing: border-box;
  }
</style> 
<div class="card">
<div class="card-footer p-0" style="background-color: #04a9f5">
  <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Admin Users</h5>
 </div>
 <div class="card-body">
  @if(count($users))
  <div class="table-responsive">
  <table class="table" id="table_id" style="width:100">
          <thead>
            <tr class="text-left">
              <th>UID</th>
              <th>Name</th>
              <th>Email</th> 
              <th>Phone</th> 
              <th>Whats App</th> 
              <th>Status</th> 
              <th>Action</th> 
            </tr>
          </thead>
          <tbody class="text-center"> 
            @foreach ($users as $user)
            <tr>
              <td>{{ $user->id }}</td>
              <td>{{ $user->name ?? "" }}</td>
              <td>{{ $user->email ?? "" }}</td>
              <td>{{ $user->phone ?? "" }}</td>
              <td>{{ $user->whats_app ?? "" }}</td>
              <td>
                @if ($user->status == 1)
                <button class="btn btn-success btn-sm" onclick="updateStatus({{ $user->id }})">Active</button>
                @else
                <button class="btn btn-danger btn-sm" onclick="updateStatus({{ $user->id }})">Inactive</button>
                @endif
             </td>
            <td> <button class="btn btn-warning btn-sm " onclick="edit({{$user->id}})">Edit</button></td> 
            </tr>
          @endforeach
          </tbody>
            <tfoot>
              <tr>
                <th>UID</th>
                <th>Name</th>
                <th>Email</th> 
                <th>Phone</th> 
                <th>Whats App</th> 
                
              <th>Status</th> 
                <th>Action</th> 
              </tr>
               </tfoot>
      </table>
  </div>
  @else
  <h2 class="text-center"><i class="fa fa-inbox"></i>&nbsp; Empty</h2>
  @endif
  </div>
</div>

<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script> 
<script>
   $('#table_id tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
    } );
 
    // DataTable
    var table = $('#table_id').DataTable({ 
         "order": [],  
         "aaSorting": [],
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
</script>