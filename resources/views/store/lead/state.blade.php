<label for="parentId">State</label>
<select class="form-control" name="state_id" id="stateId" onchange="getCity(),getTown()">
  <option value="0" selected>Select State</option> 
  @foreach ($states as $state)
      <option value="{{ $state->id }}">{{ $state->name }}</option>
  @endforeach
</select>