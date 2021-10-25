 <span>Rate Profile <i class="fas fa-arrow-down"></i></span>  
            	<ul>
       @foreach($rateprofiles as $rate_key => $rate_val)
         @if(!empty($assigned_rate))
       <li class="list-group-item m-b-10 m-t-10  z-depth-0" id="parent_id_{{$rate_key}}" style="background-color: lavender;
    opacity: 1.5;"><input type="radio" name="rate_profile_id"  value="{{$rate_key}}" class="m-r-20" style="cursor: pointer;" {{($assigned_rate==$rate_key ?'checked':'' )}} >{{$rate_val}} -{{ $rate_key }}</li>
 
       {{--  <input type="hidden" name="rate_profile_id" value="{{ $rate_key }}">
           --}}
           @else
           <li class="list-group-item m-b-10 m-t-10  z-depth-0" id="parent_id_{{$rate_key}}" style="background-color: lavender;
    opacity: 1.5;"><input type="radio" name="rate_profile_id"  value="{{$rate_key}}" class="m-r-20" style="cursor: pointer;" >{{$rate_val}} -{{ $rate_key }}</li>
           @endif
       @endforeach
            	
            </ul>