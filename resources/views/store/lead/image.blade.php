 
<div class="row">
	@if($lead->converted_to_store !== 1)
	<div class="col-lg-6 col-sm-12">
    @can('store-create', 'lead.index')
    
		<div class="text-center">
      <form id="imageForm" method="POST"  action="javascript:void(0)" accept-charset="utf-8" enctype="multipart/form-data">
				@csrf
				<div class="row">
          <div class="col-md-8">
            <div class="form-group">
              <input type="hidden" name="leadId" value="{{ $lead->id }}">
							<input class="form-control" type="file" name="image" id="image" placeholder="Choose image1" >
						</div>
					</div>
					<div class="col-md-4">
            <button type="submit" class="btn btn-dark float-left" id="submit">Upload</button>
					</div>
				</div>
			</form>
		</div>
    @endcan  
	</div>
</div>
	@endif
    <div class="row">
      @if(count($lead->images))
      @foreach ($lead->images as $image)
      <div class="col-lg-4 col-sm-6">
        
        <div class="thumbnail">
          <div class="thumb">
                  {{-- <a onclick="viewImage('{{$image->id}}')" style="cursor: pointer">
          <img src="{{ asset('public/'.$image->url.$image->name) }}" alt="" class="img-fluid img-thumbnail"></a> --}}
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
 
 <script>
        $('#imageForm').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: "{{ route('lead.image.store') }}",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,



            success: (data) => {

               if(data.errors){
                $.each(data.errors,function(field_name,error){
                        $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>');
                        $(document).find('[name='+field_name+']').addClass('input-error');
            }); 
            setTimeout(hideErrors,8000); 
          }else{
                notify('Lead Image Upload','success');
                 getImages();
                  }
        }
    });

  });      

  function hideErrors(){ 
  $(".text-danger").remove(); 
  $('input').removeClass('input-error');
  }
</script>