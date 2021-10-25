@if($id==1)
{
   
   <label for="parentId">Model Type</label>
                <select class="form-control" name="subLeadType_id">
                	 <option value="0" selected>Select Type</option> 
                	@foreach($retailTypes as type)
                     <option value="{{$type->id}}">{{$type->name}}</option> 
                    @endforeach
                </select>

}
@else
{
    <label for="parentId">Product</label>
                 <select class="form-control" name="subLeadType_id">
                 <option value="0" selected>Select Product</option> 
                	@foreach($products as product)
                 <option value="{{$product->id}}">{{$product->name}}</option> 
                  @endforeach
                </select>
}

@endif