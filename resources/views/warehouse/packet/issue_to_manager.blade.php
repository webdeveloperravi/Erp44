<div class="modal fade bd-example-modal-lg show" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="display: block;"><h5 class="modal-title">Modal title</h5>
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-body">
       <form id="issueToManagerSave" > 
        @csrf
        <div class="card-footer p-0" style="background-color: #04a9f5">
          <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Issue for Packet Process</h5>
         </div>
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
               <label class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Packet Number<span class="alert-danger">*</span></label>
               <div class="col col-sm-4 col-md-6">
    <input id="invoice" type="text" class="form-control"  autocomplete="invoice" autofocus="" value="{{ $packet->number }}" disabled> 
    <input type="hidden" class="form-control" name="packet_id" value="{{ $packet->id }}">
               </div>
               </div>

               <div class="form-group row">
               <label class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Date<span class="alert-danger">*</span></label>
               <div class="col col-sm-4 col-md-6">
               <input id="date" type="date" class="form-control" name="date" autocomplete="date" autofocus="" >
               </div>
               </div>

               <div class="form-group row">
               <label class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary"></label>
               <div class="col col-sm-4 col-md-4">
               <button type="button" class="btn btn-success" onclick="issueToManagerSave()">Submit</button> <input type="button" name="cancel" class="btn btn-warning m-l-10" onclick="closeModal()" value="Cancel">
               </div>
               </div>
  
       </form></div>
      </div>
    </div>
  </div>
  <div class="md-overlay"></div>
  <script>
    $(document).ready(function(){  
      document.getElementById("date").defaultValue = new Date().toISOString().substr(0, 10) ;
    });
  </script>