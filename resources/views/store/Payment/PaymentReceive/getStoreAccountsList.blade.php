
    <option value="0">Select Payment Account</option> 
    <option value="{{ $authUser->id }}">{{ $authUser->name }}</option> 

    @foreach ($accountGroups as $group)
<optgroup label="{{ $group->name ?? "" }}">
   @foreach ($accounts as $account)
      @if ($account->account_group_id == $group->id)
      <option value="{{ $account->id }}">{{ $account->name }}</option>
      @endif
   @endforeach 
</optgroup>    
    @endforeach  