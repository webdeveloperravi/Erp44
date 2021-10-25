<option value="0">Select Account</option>
@foreach ($accounts  as $account) 
@continue($account->id == auth('store')->user()->id)
<option value="{{ $account->id }}">{{ $account->name }}</option> 
@endforeach