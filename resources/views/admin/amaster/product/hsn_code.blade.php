<div id="Hsncode_{{$cat_id}}" style="display: none;" class="list" >
	@php
//dump($assigned_specie);
	@endphp
	{{-- <form action="{{route('product.cat.assign.color')}}" method="post" class="form" > --}}
		<form class="single_associate" method="post" action="{{route('product.cat.assign.single')}}">
			@csrf
         
         <ul>
			<input type="hidden" name="cat_id" value="{{$cat_id}}">
			<input type="hidden" name="type" value="hsn_code">
			<h5 class="msgr">HSN CODE </h5>
			@foreach($hsn_code->sortBy('name') as $hc_key => $hc_val)
			<li>
               <input type="radio" name="ids"  value="{{$hc_val->id}}"  {{$assigned_hsncode==$hc_val->id ? 'checked' : ''}} > {{$hc_val->hsn_code}}

			</li>

			@endforeach
		</ul>


<div class="row">
  <div class="align-self-center mx-auto">
<input type="submit" name="submit" class="btn  m-t-5 btn-success btn-sm" value="Attach HSNCODE">
</div>
</div>
</form>
</div>


