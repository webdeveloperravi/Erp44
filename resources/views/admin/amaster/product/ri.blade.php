<div id="Ri_{{$cat_id}}" style="display: none;" class="list" >
  @php
  // dump($assigned_ri);
  @endphp
	<form class="single_associate" method="post" action="{{route('product.cat.assign.single')}}">
		@csrf
		<h5 class=msgr">RI</h5>
		<ul>
			<input type="hidden" name="type" value="ri">
			<input type="hidden" name="cat_id" value="{{$cat_id}}">
			@foreach($ri->sortBy('from') as $key => $val)
			<li>

				<input type="radio" name="ids" {{($assigned_ri==$val['id']?'checked'


				:'' )}}  value="{{$val['id']}}" > {{$val['from']}} to {{$val['to']}}</li>

			@endforeach
		</ul>

		<div class="row">
  <div class="align-self-center mx-auto">
<input type="submit" name=""class="btn  m-t-5 btn-success btn-sm" value="Attach RI">
</div>
</div>
	</form>
</div>