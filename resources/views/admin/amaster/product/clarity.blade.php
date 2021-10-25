<div id="Clarity_{{$cat_id}}" style="display: none" class="list" >
	<form action="{{route('product.cat.assign.color')}}" method="post" class="form" >
			@csrf
			<input type="hidden" name="cat_id" value="{{$cat_id}}">
			<input type="hidden" name="type" value="clarity">
			<h5 class="msgr">Clarity</h5>
<div class="row"> 			
	<div class="col-sm" > 
		<!-- <h5> Select <- </h5> -->
		 <span>Selected <i class="fas fa-arrow-down"></i></span>
		<ul id='clarity_{{$cat_id}}_right'> 
			@forelse($assigned_clarity->sortBy('parent_sort') as $assignKey => $assignVal) 
			<li class="z-depth-0 p-2 m-2 sel"  onclick="move('mclarity_'+{{$assignVal->id}}{{$cat_id}} , 'clarity_'+{{$cat_id}}+'_')" direction="left" id="mclarity_{{$assignVal->id}}{{$cat_id}}" style="background-color: darkseagreen;
    opacity: 1.5;"> {{$assignVal->clarity}}
				<input class="mclarity_{{$assignVal->id}}{{$cat_id}}"  type="hidden" name="attach[]" value="{{$assignVal->id}}"> 
		 	</li>
			@empty 

			@endforelse 
		</ul>
	</div>
	<div class="col-sm" >
		<!-- <h5> Un Select -> </h5> -->
		 <span>Unselected <i class="fas fa-arrow-down"></i></span>
		<ul id="clarity_{{$cat_id}}_left">
			@foreach($clarity->sortBy('parent_sort')->whereNotIn('id',$assigned_clarity->pluck('id')) as $coKey =>$coVal)
				<li class="z-depth-0 p-2 m-2 unsel" onclick="move('mclarity_'+{{$coVal->id}}{{$cat_id}} , 'clarity_'+{{$cat_id}}+'_')" direction="right" id="mclarity_{{$coVal->id}}{{$cat_id}}" style="background-color: lavender;
    opacity: 1.5;"> {{$coVal->clarity}} 
					<input class="mclarity_{{$coVal->id}}{{$cat_id}}" type="hidden" name="detach[]" value="{{$coVal->id}}"> 
				</li>
			@endforeach
		</ul>
</div>
</div>
 <div class="row">
  <div class="align-self-center mx-auto">

<input type="submit" value="Attach Clarity" class="btn  m-t-5 btn-success btn-sm">
</div>
</div>
</form>
</div>
