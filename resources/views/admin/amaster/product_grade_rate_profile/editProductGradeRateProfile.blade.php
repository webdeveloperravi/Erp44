<div class="md-modal md-effect-1 md-show editModal" id="modal-1">
    <div class="card-footer " style="background-color: #04a9f5">
            <h5 class="text-white m-b-0 text-center">Edit Rate Profile</h5>
           </div>
    <div class="md-content p-2">
     
     <form id="editForm" onsubmit="event.preventDefault();"> @csrf
         <div class="row">
            @csrf
         <input type="hidden" name="old_id" value="{{ $oldGradeRateProfile->id }}">
          <div class="col-xl-3 col-md-6 col-12 mb-1">
            <div class="form-group">
               <label for="inputState">Products<span class="alert-danger">*</span></label>
               <select id="cat_id" class="form-control" name="product_id" onchange="getUnsignedGradesAndRateProfiles(this.value)">
                  <option value="{{ $product->id }}">{{ $product->name }}</option>
               </select>
            </div> 
          </div>  
          <div class="col-xl-3 col-md-6 col-12 mb-1">
            <div class="form-group">
               <label for="inputState">Grades<span class="alert-danger">*</span></label>
                <div id="gradeList">
                  <select id="grade_id" class="form-control" name="grade_id">
                  <option value="{{ $grade->id }}">{{ $grade->grade }}</option>
                  </select>
               </div> 
          </div> 
          </div> 
          <div class="col-xl-3 col-md-6 col-12 mb-1">
            <div class="form-group">
               <label for="inputState">Rate Profiles<span class="alert-danger">*</span></label>
               <div id="rateProfileList">
                  <select class="form-control" name="rate_profile_id">
                     @foreach ($unsignedRateProfiles as $profile)
                     <option value="{{ $profile->id }}">{{ $profile->name }}</option>
                     @endforeach
                  </select>
            </div> 
          </div> 
          </div>  
          <div class="col-xl-3 col-md-6 col-12 my-auto">
              <div class="form-group"> 
               <label for="inputState">Action</label>
                
               <button class="btn btn-primary" onclick="updateRateProfile()">Update</button>
               <button class="btn btn-danger" onclick="$('#edit').html('')">Close</button>
               
                </div>
          </div>  
        </div> 
  </form>
         </div>
    </div>
  <div class="md-overlay"></div>