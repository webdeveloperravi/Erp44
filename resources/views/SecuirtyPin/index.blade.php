 <div class="md-modal md-effect-1 md-show editModal" id="modal-1">
    <div class="md-content"> 
      <div class="card-footer p-0" style="background-color: #04a9f5">
        <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Issue Weight Challan</h5>
     </div>
    <form id="otpForm" > 
      @csrf 
        <div class="form-group row pt-3">
        <label class=" col-md-4 col-form-label text-md-right text-secondary">Select Manager:
        <span class="alert-danger">*</span>
        </label>
        <div class="col-sm-4 col-md-4 col-lg-2 col-xl-6 ">
          <select class="selectpicker form-control m-b-10" name="manager_id"> 
          @foreach ($users as $user)
          <option value="{{ $user->id }}">{{$user->role->name. " : " .$user->name }}</option> 
          @endforeach
          </select>
        </div>
      </div> 

             <div class="form-group row">
             <label class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Grade<span class="alert-danger">*</span></label>
             <div class="col col-sm-4 col-md-6">
  <input id="invoice" type="text" class="form-control"  autocomplete="invoice"  value="{{ $grade->grade->grade }}" disabled> 
  <input type="hidden" class="form-control" name="grade_id" value="{{ $grade
  ->id }}">
             </div>
             </div>

             <div class="form-group row">
             <label class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Date<span class="alert-danger">*</span></label>
             <div class="col col-sm-4 col-md-6">
             <input id="date5"  type="date" class="form-control" name="date" autocomplete="date" value="">
             </div>
             </div>

             <div class="form-group row">
             {{-- <label class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary"></label> --}}
             <div class="col col-sm-4 col-md-12 mb-2">
             <button type="button" class="btn btn-success float-right mx-4" onclick="issueToManagerSave()">Submit</button> 
             <button type="button" name="cancel" class="btn btn-warning float-right" onclick="closeModal()">Cancel</button>
             </div>

              
             </div>

     </form>
    </div>
  </div>
  <div class="md-overlay"></div>
  <script>
    
  </script>