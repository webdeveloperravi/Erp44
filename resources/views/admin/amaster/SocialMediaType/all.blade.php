<style>
  tfoot input {
      width: 100%;
      padding: 3px;
      box-sizing: border-box;
  }
</style> 
<div class="card">
<div class="card-footer p-0" style="background-color: #04a9f5">
<h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">All Social Media Types </h5>
</div>
<div class="card-body">
@if(count($types))
<div class="table-responsive">
<table class="table" id="table_id" style="width:100">
        <thead>
            <tr>
                <th id="click">UID</th>
                <th>Name</th>
                <th>Alias</th>
                <th>Description</th>   
                <th>Action</th>   
            </tr>
        </thead>
        <tbody>
            @php
                // dd($managers);
            @endphp
        @foreach($types as $type)
            <tr class="text-center">
                <td>{{ $type->id }}</td>
                <td>{{$type->name}}</td> 
                <td>{{$type->alias}}</td> 
                <td>{{$type->description}}</td>   
                <td><button onclick="edit({{ $type->id }})">Edit</button></td>
            </tr> 
            @endforeach
        </tbody>
          <tfoot>
                <tr> 
                <th>UID</th>
                <th>Name</th>
                <th>Alias</th>
                <th>Description</th>  
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
 