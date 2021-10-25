<div class="row">
    <div class="col-lg-6 col-sm-12">
        <div class="text-center">
            <form id="imageForm" method="POST"  action="javascript:void(0)" accept-charset="utf-8" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <input type="hidden" name="leadId" value="{{$managerId->id }}">
                            <input class="form-control" type="file" name="image" id="image" placeholder="Choose image" >
                        </div>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-dark float-left" id="submit">Upload</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="row">
  <div id="imagesAll">
    
  </div>
</div>  




 <script>
   $(document).ready(function(){
    all();

   })
     function all()
     {
        var managerId = "{{ $managerId->id }}";
        var url = "{{ route('manager.image.all',['/']) }}/"+managerId;
        $.get(url,function(data){
            $("#imagesAll").html(data);
        });
    }



        $('#imageForm').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: "{{ route('manager.image.store') }}",
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
                notify('Manager Image Upload','success');
                 all();
                  }
        }
    });

  });      

  function hideErrors(){ 
  $(".text-danger").remove(); 
  $('input').removeClass('input-error');
  }
</script>