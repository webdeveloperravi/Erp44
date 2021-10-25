 
    <div class="card invoiceCreate">
     </div> 

    <div class="invoiceView"> </div>
   
    <div class="editModal"> </div> 
 
<script>

  $(document).ready(function(){
     getInvoiceCreate();
     getInvoiceView(); 
  });

  function generateProducts(sort_id){
    $("#disbtn").prop('disabled', true);
     var sortId = sort_id;
     var url = "{{ route('gradesort.product.generate',['/'])}}/"+sortId; 
     $.get(url,function(data){
      $("#invoice").trigger("focusout");
      getInvoiceView();
     });
  }
 

  function getInvoiceCreate(){ 
     var url = "{{ route('gradesort.create',$invoiceDetail->id) }}";
     $.get(url,function(data){
        //  console.log(data);
        $(".invoiceCreate").html(data);
     });
  }

  function getInvoiceView(){ 
     var url = "{{ route('gradesort.view',$invoiceDetail->id) }}";
     $.get(url,function(data){
        $(".invoiceView").html(data);
     });
  }

  function checkCarat(carat){ 
     var enteredCarat = $("#gradeSortCarat").val();
     var carat = carat;
     if(enteredCarat > carat){
       $(".errorCarat").text("Please enter carat less than "+carat);
       $("#gradeSortCarat").val("");
     }else{
      $(".errorCarat").empty(); 
     }
  }

  function checkPiece(piece){
    //   alert("Saab");
     var enteredPiece = $("#gradeSortPiece").val();
     var piece = piece;
     if(enteredPiece > piece){
       $(".errorPiece").text("Please enter pieces less than "+piece);
       $("#gradeSortPiece").val("");
       
     }else{
      $(".errorPiece").empty();
     }
  }

  function saveGrade(){ 
    $("#saveButton").prop('disabled',true);
    var invoiceDetailId = $("#invoiceDetailId").val();
    var carat = $("#gradeSortCarat").val();
    var piece = $("#gradeSortPiece").val();
    var gradeId = $("#gradeId").val();
    var token = "{{ csrf_token() }}";
     
    $.ajax({
      url : "{{ route('gradesort.store') }}",
      method: "POST",
      data : {
        _token : token,
        invoiceDetailId : invoiceDetailId,
        piece : piece,
        gradeId : gradeId,
        carat : carat
      },
      success: function(data){
        $("#saveButton").prop('disabled',false);
         if($.isEmptyObject(data.errors)){
          $("#invoice").trigger('focusout');
          getInvoiceView();
          getInvoiceCreate();
          console.log(data.success);
         }else{
          createGradeErrors(data.errors);
          setTimeout(hideCreateGradeErrors,5000); 
         }
      }
    });
  }

  function edit(event,id){ 
      var gradeSortId = id;  
      var url = "{{ route('gradesort.edit',['/'])}}/"+gradeSortId; 

      $.get(url,function(data){
          $(".editModal").html(data);
          $(".editModal").show();
      });
  }

  function updateGrade(){
     var gradeId = $("#updateGradeId").val();
     var piece = $("#updatePiece").val();
     var carat = $("#updateCarat").val();
     var gradeSortId = $("#gradeSortId").val();
     var token = "{{ csrf_token() }}";
     var url = "{{ route('gradesort.update') }}";
     $.ajax({
        url : url,
        method: "POST",
         data:{
         _token : token,
         piece : piece,
         carat : carat,
         gradeId : gradeId,
         gradeSortId:gradeSortId
         },
         success: function(data){
          if(data == "Success"){
            $("#invoice").trigger('focusout');
            getInvoiceView();
            getInvoiceCreate();
            closeEditModal(); 
          }else{
            editGradeErrors(data.errors);
            setTimeout(hideEditGradeErrors,5000);
          }
      }
      },
     );
  }

    function deleteGrade(id){ 
        var gradeId = id; 
        var token = "{{ csrf_token() }}";

   $.ajax({
     url: "{{route('gradesort.delete')}}",
     method: 'POST', 
     data: { 
      _token: "{{ csrf_token() }}",
       gradeId:gradeId, 
     },
     success: function(data) { 
      $("#invoice").trigger('focusout');
          getInvoiceView();
          getInvoiceCreate();
        }
   });
    }

  function closeEditModal(){
      $(".editModal").empty();
  }

 
   function IssueToManager(sort_id){ 
    var url = "{{ route('issueToManager.create',['/'])}}/"+sort_id; 
        $.get(url,function(data){ 
           
      $(".modal-part").html(data);
    });
   } 

   function closeModal(){
    $(".modal-part").empty();
   }

   function issueToManagerSave(){ 
     url = "{{ route('issueToManager.store') }}"
     form_data = $("#issueToManagerSave").serialize();
     $.ajax({
       method : "post",
       data : form_data,
       url : url,
       success:function(data){
          if(data == "success"){
            $(".modal-part").empty();
            getInvoiceView();
            $("#invoice").trigger("focusout");
          }
          if(data.error){  
            $("#date").after('<span class="text-strong text-danger">' +data.error+ '</span>'); 
            setTimeout(hideErrors,5000);
          } 
          } 

          });
   }
  

  //Print Errors Messages
  function createGradeErrors(msg) {
            $("#createGradeErrors").html(''); 
            $.each( msg, function( key, value ) {
              $("#createGradeErrors").append('<div class="alert alert-danger print-error-msg">'+
                          '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                          '<i class="icofont icofont-close-line-circled"></i></button>'+
                          value+'</div>');
    });
  }
  
  function hideCreateGradeErrors(){
    $("#createGradeErrors").html(''); 
  }

  
  function editGradeErrors(msg) {
            $("#editGradeErrors").html(''); 
            $.each( msg, function( key, value ) {
              $("#editGradeErrors").append('<div class="alert alert-danger print-error-msg">'+
                          '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                          '<i class="icofont icofont-close-line-circled"></i></button>'+
                          value+'</div>');
    });
  }
  
  function hideEditGradeErrors(){
    $("#editGradeErrors").html(''); 
  }
</script>
    
 