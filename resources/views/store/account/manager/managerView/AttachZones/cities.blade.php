<div class="form-group">
    <label for="state">Select City</label> 
    <select class="form-control" name="city">
       <option value="0">ALL</option>
       @foreach ($cities as $city)
         <option value="{{ $city->id }}">{{ $city->name }}</option>  
       @endforeach
    </select>
 </div>