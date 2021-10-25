 {{-- <div class="row">
 	   @if(count($managerId->images()->orderBy('updated_at','desc')->get()))
		@foreach ($managerId->images as $image)
		<div class="col-lg-4 col-sm-6">
			<div class="thumbnail">
				<div class="thumb">
                <a onclick="viewImage('{{$image->id}}')" style="cursor: pointer">
				<img src="{{ asset('public/'.$image->url.$image->name) }}" alt="" class="img-fluid img-thumbnail"></a>
				
            </div>
            <div class="job-meta-data d-inline"><i class="icofont icofont-university"></i>{{ \Carbon\Carbon::parse($image->created_at)->diffForhumans() }}</div>
			<div class="job-meta-data  d-inline"><i class="icofont icofont-safety"></i>{{ $image->user->name }}</div>
		</div>
	</div>
    @endforeach

    @else
     
     <h2 class="text-center"><i class="fa fa-inbox"></i>&nbsp; No Images</h2>

    @endif
</div> --}}



<div class="row">
	@if(count($managerId->images()->orderBy('updated_at','desc')->get()))
	@foreach ($managerId->images as $image)
	<div class="col-lg-4 col-sm-6">
	  
	  <div class="thumbnail">
		<div class="thumb"> 
		<a href="{{ asset('public/'.$image->url.$image->name) }}" data-lightbox="1" data-title="">
		  <img src="{{ asset('public/'.$image->url.$image->name) }}" alt="" class="img-fluid img-thumbnail">
		  </a>
			</div>
			<div class="job-meta-data d-inline"><i class="icofont icofont-university"></i>{{ \Carbon\Carbon::parse($image->created_at)->diffForhumans() }}</div>
	  <div class="job-meta-data  d-inline"><i class="icofont icofont-safety"></i>{{ $image->user->name }}</div>
	</div>
  </div>
	@endforeach

	@else
	
	<h2 class="text-center"><i class="fa fa-inbox"></i>&nbsp; No Images</h2>
	@endif


</div>
 