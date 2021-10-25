<div class="card-block">
   <div class="view-info">
      <div class="row">
         <div class="col-lg-12">
            <div class="general-info">
			<form onsubmit="event.preventDefault(0)" id="updateForm">
        @csrf
               <div class="row">
                  <div class="col-lg-12 col-xl-12">
                     <div class="table-responsive">
                        <table class="table m-0">
                           <tbody>
                              <tr>
                                 <th scope="row">Gin </th>
                                 <td>{{ $product->gin }}</td>
                                 <input type="hidden" name="gin" value="{{ $product->gin }}">
                                 <td colspan="2">
                                    <button class="btn btn-success" type="button" onclick="update()">Click to Save Changes</button></td> 
                              </tr>
                              <tr>
                                 <th scope="row"> Product</th>
                                 <td>{{ $product->product->name }}</td>
                                 <td colspan="2">Rate Profile : {{ $product->rateProfile->name ?? ""  }}</td> 
                              </tr> 
                              
                              <tr>
                                 <th scope="row">Product</th>
                                 <td>{{ $product->product->name ?? "" }}+</td>
                                 <td>
                                    <span>Select yes to update : </span>
                                    <label for="chkYes">
                                    <input type="radio" id="productYes"  value="on" name="productRadio" />
                                    Yes
                                    </label>
                                    <label for="chkNo">
                                    <input type="radio" id="productYes"  value="off"  name="productRadio" checked="true"/>
                                    No
                                    </label> 
                                    <div class="form-group">
                                       <select class="form-control" name="product" id="product"  disabled="disabled" >
                                          <option value="0">Select Product</option>
                                          @foreach ($products as $producte)
                                          @if ($producte->id == $product->product->id)
                                          <option value="{{ $producte->id}}" selected>{{ $producte->name }}</option>
                                          @else	
                                          <option value="{{ $producte->id}}">{{ $producte->name }}</option>
                                          @endif
                                          @endforeach
                                       </select>
                                    </div>
                                 </td> 
                              </tr>
                              <tr>
                                 <th scope="row">Grade </th>
                                 <td>{{ $product->productGrade->alias }}</td>
                                 <td>
                                    <span>Select yes to update : </span>
                                    <label for="chkYes">
                                    <input type="radio" id="gradeYes"  value="on" name="gradeRadio" />
                                    Yes
                                    </label>
                                    <label for="chkNo">
                                    <input type="radio" id="gradeYes"  value="off"  name="gradeRadio" checked="true"/>
                                    No
                                    </label> 
                                    <div class="form-group">
                                       <select class="form-control" name="grade"  id="grade" disabled="disabled" >
                                          <option value="0">Select Grade</option>
                                          @foreach ($grades as $grade)
                                          @if ($grade->id == $product->productGrade->id)
                                          <option value="{{ $grade->id}}" selected>{{ $grade->alias }}</option>
                                          @else	
                                          <option value="{{ $grade->id}}">{{ $grade->alias }}</option>
                                          @endif
                                          @endforeach
                                       </select>
                                    </div>
                                 </td>
                                 <td>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                 </td>
                              </tr>
                              <tr>
                                 <th scope="row">Ratti</th>
                                 <td>{{ $product->ratti->rati_standard }}+</td>
                                 <td>
                                    <span>Select yes to update : </span>
                                    <label for="chkYes">
                                    <input type="radio" id="rattiYes"  value="on" name="rattiRadio" />
                                    Yes
                                    </label>
                                    <label for="chkNo">
                                    <input type="radio" id="rattiYes"  value="off"  name="rattiRadio" checked="true"/>
                                    No
                                    </label> 
                                    <div class="form-group">
                                       <select class="form-control" name="ratti" id="ratti"  disabled="disabled" >
                                          <option value="0">Select Ratti</option>
                                          @foreach ($ratties as $ratti)
                                          @if ($ratti->id == $product->ratti->id)
                                          <option value="{{ $ratti->id}}" selected>{{ $ratti->rati_standard."+" }}</option>
                                          @else	
                                          <option value="{{ $ratti->id}}">{{ $ratti->rati_standard."+" }}</option>
                                          @endif
                                          @endforeach
                                       </select>
                                    </div>
                                 </td> 
                              </tr>
                              <tr>
                                 <th scope="row">Color</th>
                                 <td>{{ $product->color->color }} 
                                 </td>
                                 <td>
                                    <span>Select yes to update : </span>
                                    <label for="chkYes">
                                    <input type="radio" id="colorYes"  value="on" name="colorRadio" />
                                    Yes
                                    </label>
                                    <label for="chkNo">
                                    <input type="radio" id="colorYes"  value="off"  name="colorRadio" checked="true"/>
                                    No
                                    </label> 
                                    <div class="form-group">
                                       <select class="form-control" name="color" id="color"  disabled="disabled" >
                                          <option value="0">Select Color</option>
                                          @foreach ($colors as $color)
                                          @if ($color->id == $product->color->id)
                                          <option value="{{ $color->id}}" selected>{{ $color->color}}</option>
                                          @else	
                                          <option value="{{ $color->id}}">{{ $color->color }}</option>
                                          @endif
                                          @endforeach
                                       </select>
                                    </div>
                                 </td> 
                              </tr>
                              <tr>
                                 <th scope="row">Clarity</th>
                                 <td>{{ $product->clarity->clarity  }}
                                 </td>
                                 <td>
                                    <span>Select yes to update : </span>
                                    <label for="chkYes">
                                    <input type="radio" id="clarityYes"  value="on" name="clarityRadio" value="wow"/>
                                    Yes
                                    </label>
                                    <label for="chkNo">
                                    <input type="radio" id="clarityYes"  value="off"  name="clarityRadio" checked="true"/>
                                    No
                                    </label> 
                                    <div class="form-group">
                                       <select class="form-control" name="clarity"  id="clarity"   disabled="disabled" >
                                          <option value="0">Select Clarity</option>
                                          @foreach ($clarities as $clarity)
                                          @if ($clarity->id == $product->clarity->id)
                                          <option value="{{ $clarity->id}}" selected>{{ $clarity->clarity}}</option>
                                          @else	
                                          <option value="{{ $clarity->id}}">{{ $clarity->clarity }}</option>
                                          @endif
                                          @endforeach
                                       </select>
                                    </div>
                                 </td> 
                              </tr>
                              <tr>
                                 <th scope="row">Origin</th>
                                 <td>{{ $product->origin->origin   }}</td>
                                 <td>
                                    <span>Select yes to update : </span>
                                    <label for="chkYes">
                                    <input type="radio" id="originYes"  value="on" name="originRadio" />
                                    Yes
                                    </label>
                                    <label for="chkNo">
                                    <input type="radio" id="originYes"  value="off"  name="originRadio" checked="true"/>
                                    No
                                    </label> 
                                    <div class="form-group">
                                       <select class="form-control" name="origin" id='origin' disabled="disabled" >
                                          <option value="0">Select Origin</option>
                                          @foreach ($origins as $origin)
                                          @if ($origin->id == $product->origin->id)
                                          <option value="{{ $origin->id}}" selected>{{ $origin->origin}}</option>
                                          @else	
                                          <option value="{{ $origin->id}}">{{ $origin->origin }}</option>
                                          @endif
                                          @endforeach
                                       </select>
                                    </div>
                                 </td> 
                              </tr>
                              <tr>
                                 <th scope="row">Shape</th>
                                 <td>{{ ucfirst($product->shape->shape)   }}</td>
                                 <td>
                                    <span>Select yes to update : </span>
                                    <label for="chkYes">
                                    <input type="radio" id="shapeYes"  value="on" name="shapeRadio" />
                                    Yes
                                    </label>
                                    <label for="chkNo">
                                    <input type="radio" id="shapeYes"  value="off"  name="shapeRadio" checked="true"/>
                                    No
                                    </label> 
                                    <div class="form-group">
                                       <select class="form-control" name="shape"  id="shape" disabled="disabled" >
                                          <option value="0">Select Shape</option>
                                          @foreach ($shapes as $shape)
                                          @if ($shape->id == $product->shape->id)
                                          <option value="{{ $shape->id}}" selected>{{ $shape->shape}}</option>
                                          @else	
                                          <option value="{{ $shape->id}}">{{ $shape->shape }}</option>
                                          @endif
                                          @endforeach
                                       </select>
                                    </div>
                                 </td>
                                 
                              </tr>
                              <tr>
                                 <th scope="row">Treatment</th>
                                 <td>{{ $product->treatment->treatment   }}</td>
                                 <td>
                                    <span>Select yes to update : </span>
                                    <label for="chkYes">
                                    <input type="radio" id="treatmentYes"  value="on" name="treatmentRadio" />
                                    Yes
                                    </label>
                                    <label for="chkNo">
                                    <input type="radio" id="treatmentYes"  value="off"  name="treatmentRadio" checked="true"/>
                                    No
                                    </label> 
                                    <div class="form-group">
                                       <select class="form-control" name="treatment" id="treatment"  disabled="disabled" >
                                          <option value="0">Select Treatment</option>
                                          @foreach ($treatments as $treatment)
                                          @if ($treatment->id == $product->treatment->id)
                                          <option value="{{ $treatment->id}}" selected>{{ $treatment->treatment}}</option>
                                          @else	
                                          <option value="{{ $treatment->id}}">{{ $treatment->treatment }}</option>
                                          @endif
                                          @endforeach
                                       </select>
                                    </div>
                                 </td> 
                              </tr>
                              <tr>
                                 <th scope="row"> Length</th>
                                 <td>{{ $product->length }}</td>
                                 <td>
                                    <span>Select yes to update : </span>
                                    <label for="chkYes">
                                    <input type="radio" id="lengthYes"  value="on" name="lengthRadio" />
                                    Yes
                                    </label>
                                    <label for="chkNo">
                                    <input type="radio" id="lengthYes"  value="off"  name="lengthRadio" checked="true"/>
                                    No
                                    </label> 
                                    <input class="form-control" type="text" name="length" id='length' value="{{ $product->length }}" disabled="disabled" >
                                 </td> 
                              </tr>
                              <tr>
                                 <th scope="row"> Width</th>
                                 <td>{{ $product->width }}</td>
                                 <td>
                                    <span>Select yes to update : </span>
                                    <label for="chkYes">
                                    <input type="radio" id="widthYes"  value="on" name="widthRadio" />
                                    Yes
                                    </label>
                                    <label for="chkNo">
                                    <input type="radio" id="widthYes"  value="off"  name="widthRadio" checked="true"/>
                                    No
                                    </label> 
                                    <input class="form-control" type="text" name="width" id="width" value="{{ $product->width }}" disabled="disabled" >
                                 </td> 
                              </tr>
                              <tr>
                                 <th scope="row"> Depth</th>
                                 <td>{{ $product->depth }}</td>
                                 <td>
                                    <span>Select yes to update : </span>
                                    <label for="chkYes">
                                    <input type="radio" id="depthYes"  value="on" name="depthRadio" />
                                    Yes
                                    </label>
                                    <label for="chkNo">
                                    <input type="radio" id="depthYes"  value="off"  name="depthRadio" checked="true"/>
                                    No
                                    </label> 
                                    <input class="form-control" type="text" name="depth" id="depth" value="{{ $product->depth }}" disabled="disabled" >
                                 </td> 
                              </tr>
                              <tr>
                                 <th scope="row"> Weight</th>
                                 <td>{{ $product->weight.$mg }}</td>
                                 <td>
                                    <span>Select yes to update : </span>
                                    <label for="chkYes">
                                    <input type="radio" id="weightYes"  value="on" name="weightRadio" />
                                    Yes
                                    </label>
                                    <label for="chkNo">
                                    <input type="radio" id="weightYes"  value="off"  name="weightRadio" checked="true"/>
                                    No
                                    </label> 
                                    <input class="form-control" type="text" name="weight" id="weight" value="{{ $product->weight }}" disabled="disabled" >
                                 </td> 
                              </tr>
                           </tbody>
                        </table>
                     </div>
                  </div>
                  <div class="col-lg-12 col-xl-6">
                     <div class="table-responsive">
                        <table class="table">
                           <tbody>
                              <tr>
                                 <th> </th>
                                 <td></td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
               {{-- <button type="button" onclick="update()">Update</button> --}}
            </form> 
            </div>
         </div>
      </div>
   </div>
</div>
 <script>
	//  $('#gradeNo').click();
	   $(function () {
		   
            $("input[name='productRadio']").click(function () { 
                if ($("#productYes").is(":checked")) {
                    $("#product").removeAttr("disabled");
                    $("#product").focus();
                } else {
                    $("#product").attr("disabled", "disabled");
                }
            });
		   
            $("input[name='gradeRadio']").click(function () { 
                if ($("#gradeYes").is(":checked")) {
                    $("#grade").removeAttr("disabled");
                    $("#grade").focus();
                } else {
                    $("#grade").attr("disabled", "disabled");
                }
            });

            $("input[name='rattiRadio']").click(function () { 
                if ($("#rattiYes").is(":checked")) {
                    $("#ratti").removeAttr("disabled");
                    $("#ratti").focus();
                } else {
                    $("#ratti").attr("disabled", "disabled");
                }
            });

            $("input[name='colorRadio']").click(function () { 
                if ($("#colorYes").is(":checked")) {
                    $("#color").removeAttr("disabled");
                    $("#color").focus();
                } else {
                    $("#color").attr("disabled", "disabled");
                }
            });

            $("input[name='clarityRadio']").click(function () { 
                if ($("#clarityYes").is(":checked")) {
                    $("#clarity").removeAttr("disabled");
                    $("#clarity").focus();
                } else {
                    $("#clarity").attr("disabled", "disabled");
                }
            });

            $("input[name='originRadio']").click(function () { 
                if ($("#originYes").is(":checked")) {
                    $("#origin").removeAttr("disabled");
                    $("#origin").focus();
                } else {
                    $("#origin").attr("disabled", "disabled");
                }
            });

            $("input[name='shapeRadio']").click(function () { 
                if ($("#shapeYes").is(":checked")) {
                    $("#shape").removeAttr("disabled");
                    $("#shape").focus();
                } else {
                    $("#shape").attr("disabled", "disabled");
                }
            });

            $("input[name='treatmentRadio']").click(function () { 
                if ($("#treatmentYes").is(":checked")) {
                    $("#treatment").removeAttr("disabled");
                    $("#treatment").focus();
                } else {
                    $("#treatment").attr("disabled", "disabled");
                }
            });

            $("input[name='lengthRadio']").click(function () { 
                if ($("#lengthYes").is(":checked")) {
                    $("#length").removeAttr("disabled");
                    $("#length").focus();
                } else {
                    $("#length").attr("disabled", "disabled");
                }
            });

            $("input[name='widthRadio']").click(function () { 
                if ($("#widthYes").is(":checked")) {
                    $("#width").removeAttr("disabled");
                    $("#width").focus();
                } else {
                    $("#width").attr("disabled", "disabled");
                }
            }); 

            $("input[name='depthRadio']").click(function () { 
                if ($("#depthYes").is(":checked")) {
                    $("#depth").removeAttr("disabled");
                    $("#depth").focus();
                } else {
                    $("#depth").attr("disabled", "disabled");
                }
            }); 

            $("input[name='weightRadio']").click(function () { 
                if ($("#weightYes").is(":checked")) {
                    $("#weight").removeAttr("disabled");
                    $("#weight").focus();
                } else {
                    $("#weight").attr("disabled", "disabled");
                }
            }); 

			//width
			//depth
			//weight
        });

		

            // $("input:radio").click(function () { 
			// 	 var current = $(this).attr('id');
			// 	 alert(current);  
            //     if ($(this).val() == 'on') { 
            //         $("input:radio").each(function(data){
            //             if($(this).val() == 'off' && $(this).attr('id') != current){
			// 			    $(this).click();
			// 			}
            //          }); 
			// 		  exit;
            //     } 
            // }); 

      
    
 </script>