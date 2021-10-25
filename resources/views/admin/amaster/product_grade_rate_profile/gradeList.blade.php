
<select id="grade_id" class="form-control" name="grade_id">
    <option selected >Choose Grade</option>
    @foreach ($unsignedGrades as $grade)
    <option value="{{ $grade->id }}">{{ $grade->grade }}</option>
    @endforeach
</select>