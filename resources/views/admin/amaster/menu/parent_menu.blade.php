<select  class="form-control parent_title" name="parent" value="{{ old('parent') }}"  autocomplete="name" autofocus>
  <option value="0"> Select Parent Menu</option>
  @foreach($gr_menu as $gm_val)
  @if($gm_val->parent=='0')
  <option value="{{ $gm_val->id }}" class="text-dark font-weight-bold">{{$gm_val->title}}</option>
  @foreach($gm_val->sub_module as $fm_val)
  
  <option value="{{ $fm_val->id }}" class="text-secondary font-weight-bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $fm_val->title}}</option>
  @foreach($fm_val->sub_module as $sn_val)
  <option value="{{ $sn_val->id }}" class="text-gray-dark font-weight-normal">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $sn_val->title}}</option>
  @foreach($sn_val->sub_module as $sn_sn_val)
  
  <option value="{{ $sn_sn_val->id }}" class="text-dark font-weight-normal">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $sn_sn_val->title}}</option>
  @foreach($sn_sn_val->sub_module as $sn_sn_sn_val)
  <option value="{{ $sn_sn_sn_val->id }}" class="text-dark font-weight-normal">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$sn_sn_sn_val->title}}</option>
  @endforeach
  @endforeach
  @endforeach
  @endforeach
  @endif
  @endforeach
</select>