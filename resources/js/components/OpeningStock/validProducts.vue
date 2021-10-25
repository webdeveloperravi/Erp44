<template>
    
    <div>
        <div class="table-responsive">
      <table class="table" id="table_idall" style="width:100">
      <thead>
         <tr>
            <!-- <th>Store UID</th> -->
            <th>Gin</th>
            <th>Product</th>
            <th>Grade</th>
            <th>Ratti</th>
            <th>Ex-Ratti</th>
            <th>Rate</th>
            <th>Ex-Amount</th>
            <th>Action</th>
         </tr>
      </thead>
      <tbody> 
         <tr class="text-left" v-for="(product,index) in validProducts" :key="index">
         
            <td>{{product.gin}}</td>
            <td>{{product.product}}</td>
            <td>{{product.grade}}</td>
            <td>{{product.ratti}}</td>
            <td>{{product.exactRatti}}</td>
            <td>{{product.exactRate}}</td>
            <td>{{product.exactAmount}}</td>
            <!-- <td><button  class="btn btn-sm btn-danger" onclick="deleteProduct('{{$id}}')">Delete</button></td> -->
         </tr> 
      </tbody>
      <tfoot>
         <tr>
            <!-- <th>Store UID</th> -->
            <th>Gin</th>
            <th>Product</th>
            <th>Grade</th>
            <th>Ratti</th>
            <th>Exact Ratti</th>
            <th>Rate From Rate Profile</th>
            <th>Exact Amount</th>
            <th>Action</th>
         </tr>
      </tfoot>
   </table>
   <div class="row">
      <!-- <input type="hidden" name="credit_to" value="{{auth('store')->user()->id}}" id="credit_to11"> -->
      <div class="col col-xl-4 col-md-4 ">
         <div class="form-group">
            <label for="parentId">Comment</label>
            <textarea name="comment" placeholder="enter Comment" id="comment"  class="form-control"></textarea>
         </div>
      </div>
      <div class="col col-xl-4 col-md-4 ">
         <div class="form-group">
            <label for="parentId">&nbsp;&nbsp;&nbsp;</label>
            <button class="btn btn-sm btn-inverse float-right form-control" onclick="saveOpeningStock11()">Save</button>
         </div>
      </div>
   </div>
</div> 
    <div > 
        </div> 
    </div>
</template>
<script>
export default {
    props:['validProducts'],
    data(){
        validProducts: validProducts
    }

}

</script>  
<script type="text/javascript">
   $(document).ready(function() {
   // Setup - add a text input to each footer cell
   $('#table_idall tfoot th').each( function () {
   var title = $(this).text();
   $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
   } );
   
   // DataTable
   var table = $('#table_idall').DataTable({
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
   
   } );
   
   
</script>  