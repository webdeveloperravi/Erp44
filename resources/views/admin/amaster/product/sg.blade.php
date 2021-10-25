<div id="Sg_{{$cat_id}}" style="display: none;" class="list">

	<form class="single_associate" method="post" action="{{route('product.cat.assign.single')}}">
		@csrf
		<h5>SG</h5>
		<ul>
			<input type="hidden" name="type" value="sg">
			<input type="hidden" name="cat_id" value="{{$cat_id}}">
			@foreach($sg->sortBy('from') as $key => $val)
			<li>

				<input type="radio" name="ids" {{($assigned_sg==$val['id']?'checked':'' )}}  value="{{$val['id']}}" > {{$val['from']}} to {{$val['to']}}</li>

			@endforeach
		</ul>

		<div class="row">
  <div class="align-self-center mx-auto">
<input type="submit" name=""class="btn  m-t-5 btn-success btn-sm" value="Attach SG">
</div>
</div>
	</form>
</div>