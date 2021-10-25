 
  <div class="md-modal md-effect-1 md-show editModal" id="modal-1">
    <div class="md-content">
    <h3>Edit Grade</h3>
    <form>
      <div class="modal-body"> 
      
        <div class="form-group row pt-3">
          <label class=" col-md-4 col-form-label text-md-right text-secondary">
           </label>
            <div class="col-sm-4 col-md-4 col-lg-2 col-xl-6 ">
             <div id="editGradeErrors">

             </div>
            
            </div>


          
        <label class=" col-md-4 col-form-label text-md-right text-secondary">Select Grade:
        <span class="alert-danger">*</span>
        </label>
        <div class="col-sm-4 col-md-4 col-lg-2 col-xl-6 mt-2">
         
        <select name="updateGradeId" id="updateGradeId" class="selectpicker form-control m-b-10" data-live-search="true" data-default="United States" data-flag="true"> 
        @foreach ($gradeList as $grade)
        <option {{ $grade->id == $gradeSort->grade_id ? "selected" : ""}} value="{{ $grade->id }}">{{ $grade->grade }}</option>
        @endforeach
        </select>
        </div>
        <input type="hidden" name="gradeSortId" id="gradeSortId" value="{{ $gradeSort->id }}">
      </div> 
      
          <div class="form-group row">
          <label class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Weight<span class="alert-danger">*</span></label>
          <div class="col col-sm-4 col-md-6">
          <input id="updateCarat" type="number" onfocusout="clearValue(event)" class="form-control" name="invoice" onkeyup="checkUpdateCarat({{$leftCarat}})" value="{{ $gradeSort->carat }}">
          <span class="messages"><p class="text-danger errorUpdateCarat"></p></span>
          </div>
          </div> 

          <div class="form-group row">
          <label class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Piece<span class="alert-danger">*</span></label>
          <div class="col col-sm-4 col-md-6">
          <input id="updatePiece" type="number" class="form-control" onfocusout="clearValue(event)" name="invoice" onkeyup="checkUpdatePiece({{$leftPiece}})" value="{{ $gradeSort->piece }}">
          <span class="messages"><p class="text-danger errorUpdatePiece"></p></span>
          </div>
          </div> 

          <div class="form-group row">
          {{-- <label class="col-xs-12 col-md-8 col-form-label text-md-right text-secondary"></label> --}}
          <div class="col col-sm-4 col-md-12 ">
          <button type="button"  class="btn btn-success float-right mx-4" onclick="updateGrade()">Save</button> 
          <button type="button" name="cancel" class="btn btn-warning float-right" onclick="closeEditModal()" >Cancel</button>
          </div>
          </div>

      </h4></div>
        </form>
  
    </div>
  </div>
  
  <div class="md-overlay"></div>
  <script>
    function checkUpdateCarat(carat){
     var enteredCarat = $("#updateCarat").val();
     var carat = carat;
     if(enteredCarat > carat){
       $(".errorUpdateCarat").text("Please enter carat less than "+carat); 
       $("#updateCarat").val("");
     }else{
      $(".errorUpdateCarat").empty(); 
     }
  }

  function checkUpdatePiece(piece){ 
     var enteredPiece = $("#updatePiece").val();
     var piece = piece;
     if(enteredPiece > piece){
       $(".errorUpdatePiece").text("Please enter pieces less than "+piece); 
       $("#updatePiece").val("");
       
     }else{
      $(".errorUpdatePiece").empty(); 
     }
  }
  </script>

 