<div class="col-xl-3 col-md-6 col-12 mb-1">
    <div class="form-group" id="state">
       <label for="parentId">Select Grade</label>
       <select class="form-control" name="grade">
          <option value="0">All</option>
          @foreach ($product->grade as $grade)
          <option value="{{ $grade->id }}">{{ $grade->alias ?? "" }}</option>
          @endforeach
       </select>
    </div>
 </div>
 <div class="col-xl-3 col-md-6 col-12 mb-1">
    <div class="form-group" id="state">
       <label for="parentId">Select Ratti</label>
       <select class="form-control" name="ratti">
          <option value="0">All</option>
          @foreach ($rattis as $ratti) 
          <option value="{{ $ratti->id }}">{{ $ratti->rati_standard }}</option>
          @endforeach
       </select>
    </div>
 </div>
 <div class="col-xl-3 col-md-6 col-12 mb-1">
    <div class="form-group" id="state">
       <label for="parentId">Select Color</label>
       <select class="form-control" name="color">
          <option value="0">All</option>
          @foreach ($product->grade as $grade)
          <option value="{{ $grade->id }}">{{ $grade->alias ?? "" }}</option>
          @endforeach
       </select>
    </div>
 </div>
 <div class="col-xl-3 col-md-6 col-12 mb-1">
    <div class="form-group" id="state">
       <label for="parentId">Select Clarity</label>
       <select class="form-control" name="clarity">
          <option value="0">All</option>
          @foreach ($product->clarity as $grade)
          <option value="{{ $grade->id }}">{{ $grade->alias ?? "" }}</option>
          @endforeach
       </select>
    </div>
 </div>
 <div class="col-xl-3 col-md-6 col-12 mb-1">
    <div class="form-group" id="state">
       <label for="parentId">Select Shape</label>
       <select class="form-control" name="shape">
          <option value="0">All</option>
          @foreach ($product->shape as $grade)
          <option value="{{ $grade->id }}">{{ $grade->alias ?? "" }}</option>
          @endforeach
       </select>
    </div>
 </div>
 <div class="col-xl-3 col-md-6 col-12 mb-1">
    <div class="form-group" id="state">
       <label for="parentId">Select Origin</label>
       <select class="form-control" name="origin">
          <option value="0">All</option>
          @foreach ($product->origin as $grade)
          <option value="{{ $grade->id }}">{{ $grade->alias ?? "" }}</option>
          @endforeach
       </select>
    </div>
 </div>
