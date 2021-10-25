<label for="parentId">Select Grade</label>
<select class="form-control" name="grade" id="gradeId" aria-readonly="true">
    <option value="0">Select Grade</option>
    @foreach ($grades->sortBy('id') as $grade)
    <option value="{{ $grade->id }}">{{ $grade->alias }}</option>  
    @endforeach
</select> 