 
<div class="card">
  <!--Card Start-->
  <div class="card-footer p-0" style="background-color: #04a9f5">
     <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Organization Role List</h5>
  </div>
  <div class="card-body">   
    <div class="table-responsive">
      <table class="table" id="table_id12" style="width:100%">
      <thead>
        <tr>
                <th>Sr.</th>
                <th>Name</th>
                <th>Retail Model</th>
                <th>Tax</th>
                <th>Unit</th>
                <th>Descripion</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
           </thead>
           <tbody>
 
               @foreach($orgRoles as $role)
               
               <tr class="text-left">
               <td>{{$loop->iteration}}</td>
               <td>{{($role->name)}}</td>
               <td>{{($role->retailModel->name ?? "")}}</td>
               <td>{{($role->taxType->name ?? "")}}</td>
               <td>{{($role->unit->name ?? "")}}</td>
               <td> 
                  <p>  <a class="mytooltip" href="javascript:void(0)"> Info<span class="tooltip-content5 d-inline"><span class="tooltip-text3 d-inline"><span class="tooltip-inner2 d-inline">
                    {{ $role->description }}.</span></span></span></a> </p> 
               </td> 
             @if($role->status==0)
              <td class="text-warning">In-active</td>
               @else
               <td class ="text-success">Active</td>
               @endif
               <td>
                 <button class="btn btn-warning btn-sm p-1" onclick="changeStatus({{$role->id}},'{{$role->status}}')"  >{{($role->status==1?"In-active":"Active")}}</button>
                
      <button class="btn btn-sm btn-primary p-1 " onclick="editProfilePermission({{$role->id}},'{{$role->name}}',`{{$role->description}}`)"> edit</button> 
          <button class="btn btn-sm btn-primary p-1 " onclick="editConfig({{$role->id}})" > Configs</button> 
          <button class="btn btn-sm btn-primary p-1 " onclick="editModules({{$role->id}})" > Modules</button>
               </td>
             </tr>
               @endforeach 
           </tbody>
           <tfoot>
            <tr>
              <th>Sr.</th>
              <th>Name</th>
              <th>Retail Model</th>
              <th>Tax</th>
              <th>Unit</th>
              <th>Descripion</th>
              <th>Status</th>
              <th>Action</th>
            </tr>  
           </tfoot>
        </table>
     </div>
     <!--******************Table End***************-->
  </div>
</div> 
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script> 
<script>
  
  //  window.$('#table_id').DataTable();
  $(document).ready(function(){

  // Setup - add a text input to each footer cell
  $('#table_id12 tfoot th').each( function () {
      var title = $(this).text();
      $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
  } );

  // DataTable
  var table = $('#table_id12').DataTable({
    "lengthMenu": [50, 75, 100 ],
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

