<div class="form-group">
	<label for="state">Select State</label> 
	<select class="form-control" name="state" onchange="getCities(this.value)">
	   <option value="0">ALL</option>
	   @foreach ($states as $state)
		<option value="{{ $state->id }}">{{ $state->name }}</option>   
	   @endforeach
	</select>
 </div>