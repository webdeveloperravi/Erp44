<label for="parentId">Select Product</label>
<select class="form-control" name="product" id="product"  onchange="getGrades(this.value)">
    <option value="0">Select Product</option>
    @foreach ($products as $product)
    <option value="{{ $product->id }}">{{ $product->name }}</option>   
    @endforeach)
</select>