<style>
    tfoot input {
      width: 100%;
      padding: 3px;
      box-sizing: border-box;
    }
</style>
<div class="card">
  <div class="card-footer p-0" style="background-color: #04a9f5">
    <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">All Cities ({{ucfirst($state->name ) }})</h5>
  </div>
<div class="card-body">
   <button class="btn btn-dark float-right my-2 mr-3" onclick="createCity({{ $state->id }})">CreateCity</button> 
   @if (count($cities)) 
     <div class="table-responsive">
      <table class="table" id="table_id3" style="width:100">
        <thead class="table-active">
        <tr>
        <th>S.No</th>
        <th>Name</th> 
        <th>Actions</th> 
      </tr>
    </thead>
    <tbody>
      
       @foreach($cities as $city)
      <tr class="text-center"> 
        <td><label>{{$loop->iteration}}</label></td>
        <td><label>{{$city->name}}</label></td> 
        <td> <button class="btn btn-warning btn-sm" onclick="edit({{$city->id}})">Edit</button></td> 
      </tr>
      @endforeach 
    </tbody>
    <tfoot>
      <tr>
      <th>S.No</th>
      <th>Name</th> 
      <th>Actions</th> 
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
  $(document).ready(function() { 
$('#table_id3 tfoot th').each( function () {
  var title = $(this).text();
  $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
});

// DataTable
var table = $('#table_id3').DataTable({
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

 
