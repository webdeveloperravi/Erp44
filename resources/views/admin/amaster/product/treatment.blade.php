<div id="Treatment_{{$cat_id}}" style="display: none;" class="list" >
	@php
//dump($specie);
	@endphp
	<form action="{{route('product.cat.assign.color')}}" method="post" class="form" >
			@csrf
			<input type="hidden" name="cat_id" value="{{$cat_id}}">
			<input type="hidden" name="type" value="treatment">
			<h5 class="msgr">Treatment</h5>

   <div class="row">
    <div class="col-sm" > 
		<span>Selected <i class="fas fa-arrow-down"></i></span>
		<ul id='treatment_{{$cat_id}}_right'> 
			@forelse($assigned_treatment->sortBy('treatment') as $assignKey => $assignVal) 
			<li  onclick="move('mtreatment_'+{{$assignVal->id}}{{$cat_id}} , 'treatment_'+{{$cat_id}}+'_')" direction="left" id="mtreatment_{{$assignVal->id}}{{$cat_id}}"class="z-depth-0 p-2 m-2 sel" style="background-color: darkseagreen;
    opacity: 1.5;"> {{$assignVal->treatment}}
				<input class="mtreatment_{{$assignVal->id}}{{$cat_id}}"  type="hidden" name="attach[]" value="{{$assignVal->id}}"> 
		 	</li>
			@empty 
				
			@endforelse 
		</ul>
	</div>
	<div class="col-sm" >
		<!-- <h5> Un Select -> </h5> -->
		 <span>Unselected <i class="fas fa-arrow-down"></i></span>
		<ul id="treatment_{{$cat_id}}_left">
			@foreach($treatment->sortBy('treatment')->whereNotIn('id',$assigned_treatment->pluck('id')) as $coKey =>$coVal)
				<li  onclick="move('mtreatment_'+{{$coVal->id}}{{$cat_id}} , 'treatment_'+{{$cat_id}}+'_')" direction="right" id="mtreatment_{{$coVal->id}}{{$cat_id}}"class="z-depth-0 p-2 m-2 unsel" style="background-color: lavender;
    opacity: 1.5;" > {{$coVal->treatment}} 
					<input class="mtreatment_{{$coVal->id}}{{$cat_id}}" type="hidden" name="detach[]" value="{{$coVal->id}}"> 
				</li>
			@endforeach
		</ul>
</div>
</div>
	 <div class="row">
  <div class="align-self-center mx-auto">
<input type="submit" name=""class="btn  m-t-5 btn-success btn-sm" value="Attach Treatment">
</div>
</div>
</form>
</div>