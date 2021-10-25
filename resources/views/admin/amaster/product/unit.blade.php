<div id="Unit_{{$cat_id}}" style="display: none" class="list" >
	<form action="{{route('product.cat.assign.color')}}" method="post" class="form" >
			@csrf
			<input type="hidden" name="cat_id" value="{{$cat_id}}">
			<input type="hidden" name="type" value="unit">
			<h5 class="msgr">Unit</h5>
<div class="row"> 			
	<div class="col-sm" > 
		<!-- <h5> Select <- </h5> -->
		 <span>Selected <i class="fas fa-arrow-down"></i></span>
		<ul id='unit_{{$cat_id}}_right'> 
			@forelse($assigned_unit->sortBy('name') as $assignKey => $assignVal) 
			<li class="z-depth-0 p-2 m-2 sel"  onclick="move('unit_'+{{$assignVal->id}}{{$cat_id}} , 'unit_'+{{$cat_id}}+'_')" direction="left" id="unit_{{$assignVal->id}}{{$cat_id}}" style="background-color: darkseagreen;
    opacity: 1.5;"> {{$assignVal->name}}
				<input class="unit_{{$assignVal->id}}{{$cat_id}}"  type="hidden" name="attach[]" value="{{$assignVal->id}}"> 
		 	</li>
			@empty 

			@endforelse 
		</ul>
	</div>
	<div class="col-sm" >
		<!-- <h5> Un Select -> </h5> -->
		 <span>Unselected <i class="fas fa-arrow-down"></i></span>
		<ul id="unit_{{$cat_id}}_left">
				@foreach($unit->sortBy('name')->whereNotIn('id',$assigned_unit->pluck('id')) as $coKey =>$coVal)
				<li class="z-depth-0 p-2 m-2 unsel" onclick="move('unit_'+{{$coVal->id}}{{$cat_id}} , 'unit_'+{{$cat_id}}+'_')" direction="right" id="unit_{{$coVal->id}}{{$cat_id}}" style="background-color: lavender;
    opacity: 1.5;"> {{$coVal->name}} 
					<input class="unit_{{$coVal->id}}{{$cat_id}}" type="hidden" name="detach[]" value="{{$coVal->id}}"> 
				</li>
			@endforeach
		</ul>
</div>
</div>
 <div class="row">
  <div class="align-self-center mx-auto">

<input type="submit" value="Attach Unit" class="btn  m-t-5 btn-success btn-sm">
</div>
</div>
</form>
</div>
