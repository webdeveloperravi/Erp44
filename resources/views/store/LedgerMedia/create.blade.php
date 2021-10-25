<div class="card">
    <div class="card-block">
        <div class="text-center">
            <form id="multiple-image-preview-ajax" method="POST"  action="javascript:void(0)" accept-charset="utf-8" enctype="multipart/form-data">
               @csrf
               <div class="row">
                  <div class="col-md-10">
                     <div class="form-group">
                        <input type="hidden" name="ledgerId" value="{{ $ledgerId }}" id="ledgerId"> 
                        <input class="form-control" type="file" name="images[]" id="images" placeholder="Choose images" multiple >
                     </div>
                     @error('images')
                     <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                     @enderror
                  </div>
                  <div class="col-md-2">
                    <button type="submit" class="btn btn-primary float-right" id="submit">Upload</button>
                 </div>
                  <div class="col-md-12">
                     <div class="mt-1 text-center"> 
                        <div class="show-multiple-image-preview row"> </div> 
                     </div>
                  </div> 
               
               </div>
            </form>
         </div>
    </div>
</div>
<script>
$(document).ready(function(e) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(function() {
        // Multiple images preview with JavaScript
        
        var ShowMultipleImagePreview = function(input, imgPreviewPlaceholder) {
            if (input.files) {
                var filesAmount = input.files.length;
                for (i = 0; i < filesAmount; i++) {
                    var reader = new FileReader();
                    reader.onload = function(event) {
                        // $($.parseHTML('<img>')).attr('src', event.target.result).addClass('img-thumbnail').appendTo(imgPreviewPlaceholder);
                        $($.parseHTML('<img>')).attr('src', event.target.result).addClass('img-thumbnail col-md-4').appendTo(imgPreviewPlaceholder);
                    }
                    reader.readAsDataURL(input.files[i]);
                }
            }
        };
        $('#images').on('change', function() {
            $(".show-multiple-image-preview").html("");
            ShowMultipleImagePreview(this, 'div.show-multiple-image-preview');
        });
    });
    $('#multiple-image-preview-ajax').submit(function(e) {
        e.preventDefault();
        
        var formData = new FormData(this);
        let TotalImages = $('#images')[0].files.length; //Total Images
        let images = $('#images')[0];
        for (let i = 0; i < TotalImages; i++) {
            formData.append('images' + i, images.files[i]);
        }
        formData.append('TotalImages', TotalImages);
        $.ajax({
            type: 'POST',
            url: "{{ route('ledgerMedia.store') }}",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: (data) => {
                imagesIndex();
                this.reset();
                // alert('Images has been uploaded using jQuery ajax with preview');
                $('.show-multiple-image-preview').html("")
            },
            error: function(data) {
                console.log(data);
            }
        });
    });
}); 
</script>
