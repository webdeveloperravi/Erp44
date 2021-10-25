
<div class="card">  
    <div class="row">
        @if($ledger->mediaImages->count() == 0)
        <div class="col-lg-6 col-sm-12">
        <h2 class="text-center text-danger py-2">No Images </h2>
    </div>
    @endif
        @foreach ($ledger->mediaImages as $image)
        <div class="col-lg-6 col-sm-6">
            <div class="thumbnail">
             <div class="thumb"> 
                <a href="{{ asset('public/'.$image->url.$image->name) }}" data-lightbox="1" data-title="">
                    <img src="{{ asset('public/'.$image->url.$image->name) }}" alt="" class="img-fluid img-thumbnail">
                    </a>
            </div>
            </div>
            </div>
        @endforeach 
</div> 
</div> 
 