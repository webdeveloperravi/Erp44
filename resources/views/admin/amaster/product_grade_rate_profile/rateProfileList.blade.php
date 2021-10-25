
<select class="form-control" name="rate_profile_id">
    <option selected >Choose Rate Profile</option>
    @foreach ($unsignedRateProfiles as $profile)
    <option value="{{ $profile->id }}">{{ $profile->name }}</option>
    @endforeach
</select>