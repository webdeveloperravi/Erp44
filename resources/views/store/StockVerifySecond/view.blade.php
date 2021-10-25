 <div class="table-responsive">
          <table class="table" id="table_id" style="width:100">
             <thead>
                <tr> 
                   <th>Product</th>
                   <th>Grade</th>
                   <th>Ratti Standard</th> 
                   <th>Count</th> 
                   <th>Action</th> 
                </tr>
             </thead>
             <tbody> 
                 <tr class="text-center"> 
                     <td>{{$product->name ?? ""}}</td>
                     <td>{{$grade->alias ?? ""}}</td>
                     <td>{{$ratti->rati_standard ?? ""}}</td> 
                     <td>{{$products->count() ?? ""}}</td> 
                     @if ($products->count() > 0)
                     <td><button onclick="getAllProducts({{ $product->id }},{{ $grade->id }},{{ $ratti->id }})">View</button></td> 
                    @else
                     <td><button onclick="getAllProducts({{ $product->id }},{{ $grade->id }},{{ $ratti->id }})">View</button></td> 
                     @endif
                 </ > 
             </tbody>
             <tfoot>
                <tr>
                    <th>Sr.No</th>
                    <th>Gin</th>
                    <th>Product</th>
                    <th>Grade</th>
                    <th>Ratti Standard</th> 
                </tr>
             </tfoot>
          </table>
       </div> 
 <script>
     //  window.$('#table_id').DataTable();
     $(document).ready(function(){

     // Setup - add a text input to each footer cell
     $('#table_id tfoot th').each( function () {
         var title = $(this).text();
         $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
     });
  
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
     });
  </script>

