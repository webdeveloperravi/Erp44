@extends('layouts.admin.app')
@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-12 col-sm-12" id="fetch">
         <div class="row">
            <h1 id="msg" style="right: 20px; position: fixed; z-index: 1; background-color: greenyellow; padding: 20px;"> </h1>
            <!-- Color Open Accordion start -->
            <div class="col-lg-12">
               @foreach($product_cate as $pc_key => $pc_val) 
               <div class="card" style="border: 1px solid grey;" >
                  <div class="card-header">
                     <h3 class="">{{$pc_val->name}}</h3>
                     <a onclick="show('pro_'+{{$pc_val->id}})" > show detail </a>
                  </div>
                  <div id="pro_{{$pc_val->id}}"  class="card" style="display:none; margin-left: 45px; border: 1px solid grey;" >
                    <div class="row m-15">
                     <!-- <a onclick="show('cat_'+{{$pc_val->id}})" >+ Category</a> -->
                     <button class="btn btn-inverse" onclick="show('cat_'+{{$pc_val->id}})">Add Product </button>
                    </div>
                     <div id="cat_{{$pc_val->id}}" style="display:none;">
                        <form method="post" action="{{route('product.cat.store')}}">
                           @csrf
                           <input type="hidden" name="type_id" value="{{$pc_val->id}}">  
                           <div class="form-group row">
                              <div class="col-md-3">
                                 <input type="text" name="name" placeholder="Product Name " class="@error('name') is-invalid @enderror form-control m-l-10">
                                 @error('name')
                                 <span class="text-danger">{{ $message }}</span>
                                 @enderror
                              </div>
                              <div class="col-md-3">
                                 <input type="text" name="alias" placeholder="alias name" class="@error('alias') is-invalid @enderror form-control">
                                 @error('alias')
                                 <span class="text-danger">{{ $message }}</span>
                                 @enderror
                              </div>
                              <div class="col-md-2">
                                 <button type="submit" class="btn btn-success btn-sm form-control" > Save Category</button>
                              </div>
                           </div>
                        </form>
                     </div>
                     @if($pc_val->Product()->exists())
                     @foreach($pc_val->Product->where('parent_id', 0)->sortBy('name') as $key => $val)
                     @php
                     $item_grade_assigned=null;
                     if($r=$val->assignCategoryGradeItem()->exists())
                     {
                     $item_grade_assigned=$val->assignCategoryGradeItem()->where('product_id',$val->id)->count();
                     }
                     @endphp
                     <div class="card-header">
                        <i class="fas fa-pencil-alt" onclick="updateCategory('edit_'+{{$val->id }})" style="cursor: pointer"></i>
                        <h5 class="card-header-text" onclick="show('child_'+{{$val->id}})" >  {{$val->name }}
                           @if(!empty($item_grade_assigned))
                          <!--  | Grade Count from Item={{$item_grade_assigned}} -->
                           @endif
                        </h5>
                        @if(!$val->subcat()->exists()) 
                        @include('admin.amaster.product.associate_links',['product_type'=>$pc_val->id])
                        @endif  
                     </div>

                      <div id="edit_{{$val->id}}" style="display:none;">
                        <form  method="POST"  enctype="multipart/form-data" class="update_category">
                           @csrf
                         <input type="hidden" name="id" value="{{ $val->id }}">
                           <div class="form-group row">
                              <div class="col-md-3">
                                 <input type="text" name="name" value="{{ $val->name }}"  class="@error('name') is-invalid @enderror form-control m-l-10">
                                 @error('name')
                                 <span class="text-danger">{{ $message }}</span>
                                 @enderror
                              </div>
                              <div class="col-md-3">
                                 <input type="text" name="alias" value="{{ $val->alias }}"  class="@error('name') is-invalid @enderror form-control m-l-10">
                                 @error('alias')
                                 <span class="text-danger">{{ $message }}</span>
                                 @enderror
                              </div>
                              <div class="col-md-2">
                                 <button type="submit" class="btn btn-warning btn-sm form-control" > Update Product</button>
                              </div>
                           </div>
                        </form>
                     </div>
                     @if($val->subcat()->exists())
                     @if($val->subcat()->exists())
                     @include('admin.amaster.product.sub_category', ['sub' => $val->subcat, "parent_id"=>$val->id ])
                     @endif
                     @endif
                     @endforeach
                     @endif
                  </div>
                  @endforeach
               </div>
            </div>
            <!-- Color Open Accordion ends -->
         </div>
      </div>
   </div>
</div>
@section('script')
<script type="text/javascript">
   function show(id){
     
    $(".list").hide();
    console.log(id);
    $("#"+id).toggle();
   
   }

    
 
 
   
   
      function updateCategory(id) {
            
     $("#"+id).toggle();
   
     // $("#"+id).on('submit',function(event){
      
     //     event.preventDefault();
     //   $.ajax({
     //     type:"POST",
     //     url :"{{route('product.category.update') }}",
     //     data :$(this).serialize(),
     //     success : function(success)
     //      {
   
     //           alert("success");
     //           fetchCategoryList();
     //           $("#"+id).hide();
     //  },
     //      error:function(errorData)
     //      {
             
     //           alert("Erros");
              
     //        console.log(errorData);
     //      }
   
     //     });  
     
     // });
   
            
   
        }
   
   $(document).ready(function(){
   
    //fetchCategories();
     
    });
   
   function fetchCategories(){
   
   
    $.ajax({
   
         url:"{{route('category.list')}}",
           type:"GET",
           success:function(res)
           {
         
            $("#fetch").html(res.html);
   
           }
   
       });
   
   }  
   
   
     
</script>
@endsection
@endsection