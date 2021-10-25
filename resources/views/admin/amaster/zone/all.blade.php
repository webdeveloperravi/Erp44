<style>
    tfoot input {
    width: 100%;
    padding: 3px;
    box-sizing: border-box;
    }
 </style>
 
                  <div class="card">
                     <div class="card-footer p-0" style="background-color: #04a9f5">
                     <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">{{ ucfirst($msg) ?? "" }}  </h5>
                     </div>
                     <div class="card-body">
                        @if (count($zones)) 
                     <div class="table-responsive">
                     <table class="table" id="table_id3" style="width:100">
                             <thead>
                                 <tr>
                   <th>S.No</th>
                   <th>Name</th>
                   <th>Alias</th>
                   <th>Description</th>
                   <th>Actions</th>
                </tr>
             </thead>
             <tbody>
                @foreach($zones as $zone)
                <tr class="text-center">
                   <td><label>{{$loop->iteration}}</label></td>
                   <td><label>{{$zone->name}}</label></td>
                   <td><label>{{$zone->alias}}</label></td>
                   <td><label>{{$zone->description}}</label></td>
                   <td> <button class="btn btn-warning btn-sm" onclick="edit({{$zone->id}})">Edit</button>
                   <button class="btn btn-primary btn-sm" onclick="zoneViewTwo({{$zone->id}})">View Areas</button></td>
                </tr>
                @endforeach 
             </tbody>
             <tfoot>
                <tr>
                   <th>S.No</th>
                   <th>Name</th>
                   <th>Alias</th>
                   <th>Description</th>
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
   

<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script> 
  <script>
          $(document).ready(function() {
      // Setup - add a text input to each footer cell
      $('#table_id3 tfoot th').each( function () {
          var title = $(this).text();
          $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
      } );
   
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

 function zoneViewTwo(zoneId){
   var url = "{{ route('zone.view.two',['/']) }}/"+zoneId;
   $.get(url,function(data){
      $("#zoneViewTwo").html(data);
      $("#attachAreasView").html('');
      $('html,body').animate({ scrollTop: 9999 }, 'slow');
   });
 }

 $(document).ready(function() {
    $('#scr-vtr-dynamic').DataTable();
});
</script>
    
 