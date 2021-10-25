<div class="md-modal md-effect-1 md-show editModal" id="modal-1">
   
    <div class="card">
      <div class="card-footer " style="background-color: #04a9f5">
        <h5 class="text-white m-b-0 text-center">Edit Cheque</h5>
       </div>
     <div class="card-body">

       <form id="editForm" onsubmit="event.preventDefault();">
           @csrf
            <input type="hidden" name="chequeId"  value="{{$cheque->id}}">
           <div class="row">
              @csrf 
              <div class="col-xl-4 col-md-6 col-12 mb-1">
                <div class="form-group">
                  <label for="basicInput">Cheque Number</label>
                  <input name="number" type="text" id="name" class="form-control" value="{{ $cheque->number }}" placeholder="Cheque Number" />
                </div>
              </div>  
              <div class="col-xl-4 col-md-6 col-12 mb-1">
                <div class="form-group">
                  <label for="basicInput">Enter Amount</label>
                  <input name="amount" type="text" class="form-control" value="{{ $cheque->amount }}" placeholder="Enter Amount" />
                </div>
              </div> 
            </div>
            <div class="row justify-content-end">
              <button class="btn btn-success saveZone float-right  m-0 mr-4" onclick="update()">Update</button> 
              <button class="btn btn-danger float-right m-0 mr-2" onclick="$('#edit').html('')">Close</button>  
            </div> 
    </form>
     </div>
         </div>
    </div>
  <div class="md-overlay"></div>

  <script type="text/javascript">
      $(document).ready(function(data){
        $("#name").focus();
      });
      
     function update(){
     let url ="{{route('cheque.update')}}";
  let formData = $("#editForm").serialize();
 
  $.ajax({
        
       url : url, 
       method : "POST",
       data : formData,
     success : function(data){
               
               if(data.success){
                 
              $("#edit").html('');
                all();
               }else{
                  $.each(data.errors,function(field_name,error){
                        $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
            }); 
            setTimeout(hideErrors,5000); 
               }
            }, 
        });
    }


    function hideErrors(){ 
   $(".text-danger").remove(); 
 }
 

  </script>
