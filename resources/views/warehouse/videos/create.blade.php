{{-- <h2 class="text-center">Laravel 8 Ajax Multiple Image Upload With Preview - Tutsmake.com</h2> --}}
<div class="card">
    <div class="card-block">
        <div class="text-center">
            <form>
               @csrf
               <div class="row">
                  <div class="col-md-12 mobile-inputs">
                      <input type="hidden" name="productId" value="{{ $productId }}" id="productId">  
                      <div class="form-group row">
                        <label class="col-sm-12 col-form-label">Youtube video url</label>
                        <div class="col-sm-12">
                        <input type="text" name="url"  class="form-control form-control-sm" placeholder="Enter Youtube Video URL" id="url">
                        </div>
                        </div> 
                      <div class="form-group row">
                        <label class="col-sm-12 col-form-label">Video width</label>
                        <div class="col-sm-12">
                        <input type="number" name="width"  class="form-control form-control-sm" placeholder="Enter Video Width" id="width">
                        </div>
                      </div> 
                  </div> 
                  <div class="col-md-12">
                     <button type="button" class="btn btn-primary float-right" id="videoStore" onclick="videoStore2()">Submit</button>
                  </div>
               </div>
            </form>
         </div>
    </div>
</div>
<script>
    // $("#videoStore").on('click',function(){
    //     videoStore();
    // });

     

    function videoStore2(){ 
      var productId = "{{ $productId }}";
      var url = $("#url").val();
      var width = $("#width").val();
      var token = $("input[name='_token']").val();
      $.ajax({
        url: "{{ route('video.store') }}",
        
        method:"POST",
        data:{
         _token: token,
           productId:productId,
           url : url,
           width : width,
        },
        success:function(data){
            videosIndex();
        }
      });
    }

    //   var url = "{{ route('image.create',['/']) }}/"+productId;
    //         $.get(url,function(data){
    //             $("#imageCreate").html(data);
    //         }); 
   
</script>
