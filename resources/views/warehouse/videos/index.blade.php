
<div class="card">  
    <div class="row justify-content-center">
        @if($videos->count() == 0)
            <div class="col-lg-12 col-sm-12">
        <h2 class="text-center text-danger py-2">No Videos </h2>
    </div>
        @endif
        @foreach ($videos as $video)
        <div class="col-lg-12 col-sm-12"> 
            {{-- {!! $video->url !!} --}}
            
                    {!! $video->getVideoWithWidth($video->url,430) !!}
               
            </div>
        @endforeach 
</div> 
</div> 
 