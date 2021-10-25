<div id="Species_{{$cat_id}}" style="display: none;" class="list" >
	@php
//dump($assigned_specie);
	@endphp
	{{-- <form action="{{route('product.cat.assign.color')}}" method="post" class="form" > --}}
		<form class="single_associate" method="post" action="{{route('product.cat.assign.single')}}">
			@csrf
         
         <ul>
			<input type="hidden" name="cat_id" value="{{$cat_id}}">
			<input type="hidden" name="type" value="specie">
			<h5 class="msgr">Specie</h5>
			@foreach($specie->sortBy('species') as $sp_key => $sp_val)
			<li>
               <input type="radio" name="ids" {{($assigned_specie==$sp_val->id ?'checked':'')}}  value="{{$sp_val->id}}" > {{$sp_val->species}}

			</li>

			@endforeach
		</ul>


<div class="row">
  <div class="align-self-center mx-auto">
<input type="submit" name="submit" class="btn  m-t-5 btn-success btn-sm" value="Attach Specie">
</div>
</div>
</form>
</div>


