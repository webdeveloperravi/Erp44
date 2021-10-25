 <div class="md-modal md-effect-1 md-show editModal" id="modal-1">
    <div class="card-footer p-0" style="background-color: #04a9f5">
			<h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Edit Comment</h5>
		   </div>
		
    <div class="md-content p-2">
     
   <form id="editCommentForm" onsubmit="event.preventDefault();" class="pt-3"> 
    @csrf
      <input type="hidden" name="commentId"  value="{{$comment->id}}">
    
       

       <div class="form-group row py-3 justify-content-right" >
          <div class="col">
            <textarea rows="5" cols="5" class="form-control" placeholder="Write Something here..." name="body">{{ $comment->body }}</textarea> 
        </div>
      
      </div> 
       <div class="form-group row py-3 justify-content-right" >
          <div class="col">
          <button class="btn btn-success saveZone float-right  m-0 mr-4" onclick="updateComment()">Update</button> 
          <button class="btn btn-danger float-right m-0 mr-2" onclick="$('#editComment').html('')">Close</button>  
        </div>
      
      </div> 
    </form>
    </div>

  </div>
  <div class="md-overlay"></div>