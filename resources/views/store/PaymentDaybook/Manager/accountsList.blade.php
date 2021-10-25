{{-- <option value="0">Select Account</option>
@if (isset($authUser))
<option value="{{ $authUser->id }}">Current - 
@if ($authUser->type == 'lab' || $authUser->type == 'org')
 ({{$authUser->company_name}})   
@else
 ({{$authUser->name}})   
@endif
</option>
  <option value="all">All</option>  
@endif --}}
@foreach ($accounts  as $account) 
{{-- @continue($account->id == auth('store')->user()->id)  --}}
<option value="{{ $account->id }}">{{ $account->name }}</option>  
@endforeach