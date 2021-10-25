<label for="parentId">City</label>
<select class="form-control" name="city_id">
    <option value="0" selected>Select City</option>
    @foreach ($cities as $city)
      <option value="{{ $city->id }}">{{ $city->name }}</option>
  @endforeach
</select>