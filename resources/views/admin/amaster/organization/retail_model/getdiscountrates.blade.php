<select name="discountRate"  class="form-control">
    <option  selected="" value="0">Select Discount Rate</option>
   @foreach ($discountRates as $dis_val)
       <option value="{{$dis_val->id}}">{{$dis_val->name}} ({{ $dis_val->rate."%" }})</option>
    @endforeach
</select>