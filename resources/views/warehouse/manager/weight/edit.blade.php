
   
   <style>
    thead input {
        width: 100%;
        padding: 3px;
        box-sizing: border-box;
    }
</style>   
<div class="md-modal md-effect-1 md-show" id="modal-1">
    <div class="md-content">
    <h3>Edit Weight</h3>
    <div>
        <div class="table-responsive"> 
            <table class="table">
            <thead>
                <tr> 
                    <th>UID</th>
                    <th>Weight</th> 
                    <th colspan="2">Action</th> 
                </tr>
            </thead>
            <tbody>
             <tr id="myTable"> 
                <td>{{ $product->id }}</td>
                <input type="hidden" name="product_id" id="product_id" value="{{ $product->id }}">
                <td>
                    {{-- <input type="text" id="weight" name="weight" class="form-control" placeholder="enter weight" value="{{ $product->weight ?? "" }}" onfocusout="clearValue(event)"> --}}
                    <input type="number" step=".01" id="weight" name="weight" class="form-control" onkeypress="javascript: if(event.keyCode == 13) saveWeight();" placeholder="Enter weight"    value="{{ $product->weight ?? "" }}"/>
                </td> 
                 <td><button class="btn btn-success" onclick="saveWeight()">Update</button>
                
        <button type="button" class="btn btn-danger waves-effect md-close " onclick="closeEditModal()">Close</button></td>
             </tr>
             <tr>
                 <td></td>
                 <td></td>
                 <td></td>
                 <td></td>
             </tr>
            </tbody>
        </table>
        
        </div> 
    </div>
    </div>
    </div> 
    <div class="md-overlay"></div>
    
    <script>
    	function clearValue(event){
    val = event.target.value;
    if(val == 0 ){
      event.target.value="";
    } 
  }
$(document).ready(function(){
  foc();
});
  function foc(){
      $("#weight").focus();
  }
  </script>