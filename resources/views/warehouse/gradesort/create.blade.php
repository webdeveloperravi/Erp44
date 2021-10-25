@if(($leftCarat != 0) || ($leftPiece != 0)) 
<div class="card-block p-3">
  <div class="row">
     <div class="col-md-6 col-lg-3">
        <div class="card">
           <div class="card-block text-center">
              <i class="feather icon-twitter text-c-green d-block f-28"></i>
              <h5 class="m-t-20">{{ $invoiceDetail->product->name }}</h5>
           </div>
           <div class="card-footer bg-c-green">
              <h6 class="text-white m-b-0 text-center">Product</h6>
           </div>
        </div>
     </div>
     <div class="col-md-6 col-lg-3">
        <div class="card statustic-card">
           <div class="card-block text-center">
              <span class="d-block text-c-blue f-28">{{ $leftCarat.$mg }}</span>
              <p class="m-b-0">Left Weight</p>
           </div>
           <div class="card-footer" style="background-color: #04a9f5">
              <h6 class="text-white m-b-0 text-center">Total Weight : {{ $invoiceDetail->carat.$mg }}</h6>
           </div>
        </div>
     </div>
     <div class="col-md-6 col-lg-3">
        <div class="card statustic-card">
           <div class="card-block text-center">
              <span class="d-block text-c-yellow f-28">{{ $leftPiece }}</span>
              <p class="m-b-0">Left Pieces</p>
           </div>
           <div class="card-footer bg-c-yellow">
              <h6 class="text-white m-b-0 text-center">Total Pieces :{{ $invoiceDetail->piece }}</h6>
           </div>
        </div>
     </div>
  </div>
  <div id="createGradeErrors"></div>

  @if(\App\Helpers\CheckPermission::instance()->viewAction('gradesort-create'))
  <div class="table-responsive ">
     <table class="table table-bordered  ">
        <thead class="">
           <tr class="table-active">
              <th>Select Grade</th>
              <th>Weight</th>
              <th>Piece</th>
              <th>Action</th>
           </tr>
        </thead>
        <form id="gradeCreateForm">
           <tbody>
              <tr class="text-center">
                 <td>
                    <select class=" selectpicker form-control " id="gradeId" name="gradeId"  data-live-search="true" data-default="Product Type"
                       data-flag="true">
                       <option  disabled>Select Grade</option>
                       @foreach ($gradeList as $grade)
                       @continue(in_array($grade->id,$oldGrades))
                       <option value="{{ $grade->id }}">{{ $grade->grade }}</option>
                       @endforeach
                    </select>
                    <!-- Product type Select Entery End -->
                 </td>
                 <input type="hidden" name="invoiceDetailId" id="invoiceDetailId" value="{{ $invoiceDetail->id }}">
                 <td>
                    <input name="carat" type="number" id="gradeSortCarat" required="" onfocusout="checkCarat({{ $leftCarat }});clearValue(event)" class="form-control" autocomplete="off">
                    <span class="messages">
                       <p class="text-danger errorCarat"></p>
                    </span>
                 </td>
                 <td>
                    <input type="number" id="gradeSortPiece" required="" onfocusout="checkPiece({{ $leftPiece }});clearValue(event)" name="piece" class="form-control"  autocomplete="off" onkeypress="javascript: if(event.keyCode == 13) saveGrade();">
                    <span class="messages">
                       <p class="text-danger errorPiece"></p>
                    </span>
                 </td>
                 <td>
                    <button type="button" id="saveButton" class="btn btn-success btn-sm" onclick="saveGrade()">Next</button>
                 </td>
              </tr>
           </tbody>
        </form>
     </table>
  </div>
  @endif
  @else 
  <div class="progress progress-xl"> 
    <div class="progress-bar progress-bar-striped progress-bar-success" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><h5 class="pt-1">Grade Sort Complete</h5></div>
  </div>
  @endif
</div>
<script>
  function clearValue(event){
    val = event.target.value;
    if(val == 0 ){
      event.target.value="";
    } 
  }
</script>