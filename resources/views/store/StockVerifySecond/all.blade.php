 <div class="row">
    <div class="col-md-6">
        <form  onsubmit="event.preventDefault();" id="verifyForm">
            <div class="row">
            @csrf 
            <div class="col-xl-4 col-md-6 col-12 mb-1 inline">
            <label for="inlineFormEmail" class="m-2">GIN Number:</label>
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="grade_id" value="{{ $grade->id }}">
            <input type="hidden" name="ratti_id" value="{{ $ratti->id }}">
           <input type="text" class="form-control m-2" id="gin" placeholder="Enter Gin" name="gin">
           </div>
            <div class="col-xl-4 col-md-6 col-12 m-t-35">
           <button type="button" class="btn btn-primary m-2 btn-sm" onclick="verify()">Verify</button>
           </div>
            </div>
            </form>  
    </div>
</div>
  <div class="row">
      <div class="col-md-6">
        <div class="card">
            <div class="card-footer p-2" style="background-color: #04a9f5">
               <h5 class="text-white m-b-0 text-left d-inline" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Verified Stock</h5> 
            </div>
         
             <div class="card-body"> 
                @if (count($verifiedProducts))
                <div class="table-responsive">
                   <table class="table" id="table_id2" style="width:100">
                      <thead>
                         <tr> 
                            <th>Gin</th>` 
                         </tr>
                      </thead>
                      <tbody>
                         
                          @foreach ($verifiedProducts as $product)
                          <tr class="text-center"> 
                              <td>{{$product->gin ?? ""}}</td> 
                           </tr>
                          @endforeach
                      </tbody>
                      <tfoot>
                         <tr> 
                             <th>Gin</th> 
                         </tr>
                      </tfoot>
                   </table>
                </div>
                @else
                <h2 class="text-center"><i class="fa fa-inbox"></i>&nbsp;Empty</h2>
                @endif
             </div>
          </div>
      </div>
      <div class="col-md-6">
        <div class="card">
            <div class="card-footer p-2" style="background-color: #04a9f5">
               <h5 class="text-white m-b-0 text-left d-inline" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Unverified Stock</h5> 
            </div>
         
             <div class="card-body">  
                 @if (count($unVerifiedProducts))
                <div class="table-responsive">
                   <table class="table" id="table_id2" style="width:100">
                      <thead>
                         <tr> 
                            <th>Gin</th>
                         </tr>
                      </thead>
                      <tbody>
                        
                        @foreach ($unVerifiedProducts as $product)
                        <tr class="text-center"> 
                            <td>{{$product->gin ?? ""}}</td> 
                         </tr>
                        @endforeach
                       
                      </tbody>
                      <tfoot>
                         <tr> 
                             <th>Gin</th> 
                         </tr>
                      </tfoot>
                   </table>
                </div>
                @else
                <h2 class="text-center"><i class="fa fa-inbox"></i>&nbsp;Empty</h2>
                @endif
             </div>
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

