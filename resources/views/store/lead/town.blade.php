<label for="parentId">Town</label>
<select class="form-control" name="town_id">
    <option value="0" selected>Select Town</option>
    @foreach ($cities as $city)
      <option value="{{ $city->id }}">{{ $city->name }}</option>
  @endforeach
</select>