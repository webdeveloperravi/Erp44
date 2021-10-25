<style>
  tfoot input {
      width: 100%;
      padding: 3px;
      box-sizing: border-box;
  }
</style> 
<div class="card">
<div class="card-footer p-0" style="background-color: #04a9f5">
  <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Store View Masters</h5>
 </div>
 <div class="card-body">
  @if(count($masters))
  <div class="table-responsive">
  <table class="table" id="table_id" style="width:100">
          <thead>
            <tr class="text-left">
              <th>UID</th>
              <th>Domain</th>
              <th>Email</th> 
              <th>Phone</th>   
              <th>Address</th>   
              <th>Action</th> 
            </tr>
          </thead>
          <tbody class="text-center"> 
            @foreach ($masters as $master)
            <tr>
              <td>{{ $master->id }}</td>
              <td>{{ $master->domain ?? "" }}</td>
              <td>{{ $master->email ?? "" }}</td>
              <td>{{ $master->phone ?? "" }}</td> 
              <td>{{ $master->address ?? "" }}</td>  
            <td> <button class="btn btn-warning btn-sm " onclick="edit({{$master->id}})">Edit</button></td> 
            </tr>
          @endforeach
          </tbody>
            <tfoot>
              <tr>
                <th>UID</th>
                <th>Domain</th>
                <th>Email</th> 
                <th>Phone</th>   
                <th>Address</th>   
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