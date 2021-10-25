 
@if(!empty($product_cat)) 
@foreach($product_cat as $key => $value)
     
    {{-- @continue(in_array($key,$oldCategories)) --}}
     
    <option value="{{$key}}">{{$value}}</option> 
    
@endforeach


  {{-- @foreach($product_cat as $key => $value)
    <option value="{{$key}}">{{$value}}</option>
  @endforeach --}}
@endif