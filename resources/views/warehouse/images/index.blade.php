
<div class="card">  
    <div class="row">
        <div class="col-lg-6 col-sm-12">
            @if($images->count() == 0)
        <h2 class="text-center text-danger py-2">No Images </h2>
        @endif
        </div>
        @foreach ($images as $image)
        <div class="col-lg-6 col-sm-6">
            <div class="thumbnail">
             <div class="thumb"> 
            <img src="{{ asset($image->url.$image->name) }}" alt="" class="img-fluid img-thumbnail">
            </a>
            </div>
            </div>
            </div>
        @endforeach 
</div> 
</div> 
 