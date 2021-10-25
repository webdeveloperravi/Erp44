  
  <div class="media"> 
                <div class="media-body">
                <form id="commentForm" action="javascript:void(0);">
                    @csrf
                    <input type="hidden" name="manager_id" value="{{ $managerId->id }}">
                <div class="">
            <textarea rows="2" cols="5" class="form-control" placeholder="Write Something here..." name="body"></textarea>
                 <div class="text-right m-t-20"><button class="btn btn-sm btn-primary waves-effect waves-light" onclick="store()">Post</button></div>
                </div>
                </form>
            </div>
</div>

 
<div id="all5">
  
</div> 

<script type="text/javascript">
	
$(document).ready(function(){
        all();
        // createComment();
        //getImages();
    });

    function all(){
        var managerId = "{{ $managerId->id }}";
        var url = "{{ route('manager.comment.all',['/']) }}/"+managerId;
        $.get(url,function(data){
            $("#all5").html(data);
        });
    }

    function store(){
       
        $.ajax({
          url: "{{route('manager.comment.store')}}",
          method : "POST",
          data : $("#commentForm").serialize(),
          success : function(data){
            if(data.errors){
                $.each(data.errors,function(field_name,error){
                        $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
                        $(document).find('[name='+field_name+']').addClass('input-error')
            }); 
            setTimeout(hideErrors,8000); 
          }else{
             notify('Comment Saved','success');
              all();
            
          }
       },
         });
    }

  function hideErrors(){ 
  $(".text-danger").remove(); 
  $('input').removeClass('input-error');
  $('textarea').removeClass('input-error');
  $('select').removeClass('input-error');
}

    function edit(commentId){
        var url = "{{ route('manager.comment.edit',['/']) }}/"+commentId;
        
        $.get(url,function(data){
        //    console.log(data);
            $("#editComment").html(data);
        });
    }

    function update(){
        $.ajax({
          url: "{{ route('manager.comment.update') }}",
          method : "POST",
          data : $("#editCommentForm").serialize(),
          success : function(data){
             notify('Manager Comment Updated','success');
                $("#editComment").html('');
                all();
          }
        });
    }

</script>