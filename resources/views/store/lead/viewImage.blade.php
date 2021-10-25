 <div class="md-modal md-effect-1 md-show editModal" id="modal-1">
 <div class="modal-dialog">
   <div class="modal-content" style="text-align: center;">
       <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">View Image</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#viewImage').html('')">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        
           
              <div class="row">
                <div class="col-m-12 col">
               <h2> <img  alt=""></h2>
               <img id="myImg" src="{{ asset('public/'.$image->url.$image->name) }}" alt="Snow" style="width:100%">
         </div>
         </div>
    </div>
</div>
</div>
<div class="md-overlay"></div>