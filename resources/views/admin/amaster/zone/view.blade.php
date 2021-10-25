 
<style>
  tfoot input {
      width: 100%;
      padding: 3px;
      box-sizing: border-box;
  }
</style> 
<div class="card">
    <div class="card-footer p-0" style="background-color: #04a9f5">
        <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">{{ $zone->name }}</h5>
       </div> 
   
    <div class="card-body">
        
        <div class="row justify-content-center">
            <div class="col-md-12"> 
                <button class="btn btn-dark float-right mb-2" onclick="attachAreasView({{ $zone->id }})">Edit areas</button>
                <button class="btn btn-success btn-sm float-left" id="zoneViewRefresh" onclick="zoneViewTwo({{ $zone->id }})"><i class="fa fa-refresh"></i>Refresh</button>
            </div>
            <div class="col-md-12">
              @if (count($zone->cities))
                  
              <div class="table-responsive">
                <table class="table" id="table_id_area" style="width:100">
                    <thead>
                      <tr>
                        <th>S.No</th>
                        <th>Name</th>  
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($zone->cities as $city)
                        <tr class="text-center"> 
                        <td><label>{{ $loop->iteration }}</label></td>
                        <td><label>{{ $city->name }}</td>  
                      </tr>  
                      @endforeach
                       
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>S.No</th>
                        <th>Name</th>  
                      </tr>
                    </tfoot>
                  </table>
                  </div> 
                  @else
                  <h2 class="text-center"><i class="fa fa-inbox"></i>&nbsp; Empty</h2>
                  @endif 
            </div>
        </div>   
    </div>
</div> 

<div id="attachAreasView"></div>
<script>
  $(document).ready(function() {
// Setup - add a text input to each footer cell
$('#table_id_area tfoot th').each( function () {
  var title = $(this).text();
  $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
});

// DataTable
var table = $('#table_id_area').DataTable({
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

} );

</script>





 