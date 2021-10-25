<div id="Origin_{{$cat_id}}" style="display: none" class="list"  >
	<form action="{{route('product.cat.assign.color')}}" method="post" class="form" >
			@csrf
			<input type="hidden" name="cat_id" value="{{$cat_id}}">
			<input type="hidden" name="type" value="origin">
				<h5 class="msgr">Origin</h5>
<div class="row">

		
	<div class="col-sm" > 
		<!-- <h5> Select <- </h5> -->
		<span>Selected <i class="fas fa-arrow-down"></i></span>
		<ul id='origin_{{$cat_id}}_right'> 
			@forelse($assigned_origin->sortBy('origin') as $assignKey => $assignVal) 
			<li  onclick="move('morigin_'+{{$assignVal->id}}{{$cat_id}} , 'origin_'+{{$cat_id}}+'_')" direction="left" id="morigin_{{$assignVal->id}}{{$cat_id}}"  class="z-depth-0 p-2 m-2 sel" style="background-color: darkseagreen;
    opacity: 1.5;"> 
 {{$assignVal->origin}}
				<input class="morigin_{{$assignVal->id}}{{$cat_id}}"  type="hidden" name="attach[]" value="{{$assignVal->id}}"> 
		 	</li>
			@empty 
				
			@endforelse 
		</ul>
	</div>
	<div class="col-sm" >
		<!-- <h5> Un Select -> </h5> -->
		 <span>Unselected <i class="fas fa-arrow-down"></i></span>
		<ul id="origin_{{$cat_id}}_left">
			@foreach($origin->sortBy('origin')->whereNotIn('id',$assigned_origin->pluck('id')) as $coKey =>$coVal)
				<li  onclick="move('morigin_'+{{$coVal->id}}{{$cat_id}} , 'origin_'+{{$cat_id}}+'_')" direction="right" id="morigin_{{$coVal->id}}{{$cat_id}}" class="z-depth-0 p-2 m-2 unsel" style="background-color: lavender;
    opacity: 1.5;">  {{$coVal->origin}} 
					<input class="morigin_{{$coVal->id}}{{$cat_id}}" type="hidden" name="detach[]" value="{{$coVal->id}}"> 
				</li>
			@endforeach
		</ul>
</div>
</div>
 <div class="row">
  <div class="align-self-center mx-auto">
<input type="submit" name=""class="btn  m-t-5 btn-success btn-sm" value="Attach Origin">
</div>
</div>
</form>
</div>