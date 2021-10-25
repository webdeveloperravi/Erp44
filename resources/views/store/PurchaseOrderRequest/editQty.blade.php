<div class="md-modal md-effect-1 md-show editModal" id="modal-1">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="card-footer p-0" style="background-color: #04a9f5">
        <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Edit Qty</h5>
         </div>
        <div class="modal-body">
          <form id="editQtyForm" onsubmit="event.preventDefault();" class="pt-3"> 
                  @csrf
                  <input type="hidden" name="detailId"  value="{{ $detail->id }}"> 
                   <div class="col-xl-12 col-md-6 col-12 mb-1">
                <div class="form-group">
                    <label for="parentId">Qty</label>
                    <input class="form-control" type="number" name="qty" value="{{ $detail->confirmed_qty }}">
                  </div>
                </div>
          </form>        
                  
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success" onclick="updateQty()">Update</button>
          <button type="button" class="btn btn-secondary" onclick="$('#editQty').html('')">Close</button>
        </div>
      </div>
    </div>
  </div>
   <div class="md-overlay"></div>
  
   