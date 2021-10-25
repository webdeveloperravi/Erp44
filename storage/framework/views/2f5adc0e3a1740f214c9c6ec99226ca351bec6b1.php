<div class="card-block">
   <div class="view-info">
      <div class="row">
         <div class="col-lg-12">
            <div class="general-info">
			<form onsubmit="event.preventDefault(0)" id="updateForm">
        <?php echo csrf_field(); ?>
               <div class="row">
                  <div class="col-lg-12 col-xl-12">
                     <div class="table-responsive">
                        <table class="table m-0">
                           <tbody>
                              <tr>
                                 <th scope="row">Gin </th>
                                 <td><?php echo e($product->gin); ?></td>
                                 <input type="hidden" name="gin" value="<?php echo e($product->gin); ?>">
                                 <td colspan="2">
                                    <button class="btn btn-success" type="button" onclick="update()">Click to Save Changes</button></td> 
                              </tr>
                              <tr>
                                 <th scope="row"> Product</th>
                                 <td><?php echo e($product->product->name); ?></td>
                                 <td colspan="2">Rate Profile : <?php echo e($product->rateProfile->name ?? ""); ?></td> 
                              </tr> 
                              
                              <tr>
                                 <th scope="row">Product</th>
                                 <td><?php echo e($product->product->name ?? ""); ?>+</td>
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
                                          <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producte): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                          <?php if($producte->id == $product->product->id): ?>
                                          <option value="<?php echo e($producte->id); ?>" selected><?php echo e($producte->name); ?></option>
                                          <?php else: ?>	
                                          <option value="<?php echo e($producte->id); ?>"><?php echo e($producte->name); ?></option>
                                          <?php endif; ?>
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                       </select>
                                    </div>
                                 </td> 
                              </tr>
                              <tr>
                                 <th scope="row">Grade </th>
                                 <td><?php echo e($product->productGrade->alias); ?></td>
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
                                          <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                          <?php if($grade->id == $product->productGrade->id): ?>
                                          <option value="<?php echo e($grade->id); ?>" selected><?php echo e($grade->alias); ?></option>
                                          <?php else: ?>	
                                          <option value="<?php echo e($grade->id); ?>"><?php echo e($grade->alias); ?></option>
                                          <?php endif; ?>
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                 <td><?php echo e($product->ratti->rati_standard); ?>+</td>
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
                                          <?php $__currentLoopData = $ratties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ratti): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                          <?php if($ratti->id == $product->ratti->id): ?>
                                          <option value="<?php echo e($ratti->id); ?>" selected><?php echo e($ratti->rati_standard."+"); ?></option>
                                          <?php else: ?>	
                                          <option value="<?php echo e($ratti->id); ?>"><?php echo e($ratti->rati_standard."+"); ?></option>
                                          <?php endif; ?>
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                       </select>
                                    </div>
                                 </td> 
                              </tr>
                              <tr>
                                 <th scope="row">Color</th>
                                 <td><?php echo e($product->color->color); ?> 
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
                                          <?php $__currentLoopData = $colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                          <?php if($color->id == $product->color->id): ?>
                                          <option value="<?php echo e($color->id); ?>" selected><?php echo e($color->color); ?></option>
                                          <?php else: ?>	
                                          <option value="<?php echo e($color->id); ?>"><?php echo e($color->color); ?></option>
                                          <?php endif; ?>
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                       </select>
                                    </div>
                                 </td> 
                              </tr>
                              <tr>
                                 <th scope="row">Clarity</th>
                                 <td><?php echo e($product->clarity->clarity); ?>

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
                                          <?php $__currentLoopData = $clarities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $clarity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                          <?php if($clarity->id == $product->clarity->id): ?>
                                          <option value="<?php echo e($clarity->id); ?>" selected><?php echo e($clarity->clarity); ?></option>
                                          <?php else: ?>	
                                          <option value="<?php echo e($clarity->id); ?>"><?php echo e($clarity->clarity); ?></option>
                                          <?php endif; ?>
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                       </select>
                                    </div>
                                 </td> 
                              </tr>
                              <tr>
                                 <th scope="row">Origin</th>
                                 <td><?php echo e($product->origin->origin); ?></td>
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
                                          <?php $__currentLoopData = $origins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $origin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                          <?php if($origin->id == $product->origin->id): ?>
                                          <option value="<?php echo e($origin->id); ?>" selected><?php echo e($origin->origin); ?></option>
                                          <?php else: ?>	
                                          <option value="<?php echo e($origin->id); ?>"><?php echo e($origin->origin); ?></option>
                                          <?php endif; ?>
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                       </select>
                                    </div>
                                 </td> 
                              </tr>
                              <tr>
                                 <th scope="row">Shape</th>
                                 <td><?php echo e(ucfirst($product->shape->shape)); ?></td>
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
                                          <?php $__currentLoopData = $shapes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shape): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                          <?php if($shape->id == $product->shape->id): ?>
                                          <option value="<?php echo e($shape->id); ?>" selected><?php echo e($shape->shape); ?></option>
                                          <?php else: ?>	
                                          <option value="<?php echo e($shape->id); ?>"><?php echo e($shape->shape); ?></option>
                                          <?php endif; ?>
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                       </select>
                                    </div>
                                 </td>
                                 
                              </tr>
                              <tr>
                                 <th scope="row">Treatment</th>
                                 <td><?php echo e($product->treatment->treatment); ?></td>
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
                                          <?php $__currentLoopData = $treatments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $treatment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                          <?php if($treatment->id == $product->treatment->id): ?>
                                          <option value="<?php echo e($treatment->id); ?>" selected><?php echo e($treatment->treatment); ?></option>
                                          <?php else: ?>	
                                          <option value="<?php echo e($treatment->id); ?>"><?php echo e($treatment->treatment); ?></option>
                                          <?php endif; ?>
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                       </select>
                                    </div>
                                 </td> 
                              </tr>
                              <tr>
                                 <th scope="row"> Length</th>
                                 <td><?php echo e($product->length); ?></td>
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
                                    <input class="form-control" type="text" name="length" id='length' value="<?php echo e($product->length); ?>" disabled="disabled" >
                                 </td> 
                              </tr>
                              <tr>
                                 <th scope="row"> Width</th>
                                 <td><?php echo e($product->width); ?></td>
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
                                    <input class="form-control" type="text" name="width" id="width" value="<?php echo e($product->width); ?>" disabled="disabled" >
                                 </td> 
                              </tr>
                              <tr>
                                 <th scope="row"> Depth</th>
                                 <td><?php echo e($product->depth); ?></td>
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
                                    <input class="form-control" type="text" name="depth" id="depth" value="<?php echo e($product->depth); ?>" disabled="disabled" >
                                 </td> 
                              </tr>
                              <tr>
                                 <th scope="row"> Weight</th>
                                 <td><?php echo e($product->weight.$mg); ?></td>
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
                                    <input class="form-control" type="text" name="weight" id="weight" value="<?php echo e($product->weight); ?>" disabled="disabled" >
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

      
    
 </script><?php /**PATH E:\newxampp\htdocs\erp2\resources\views/store/ProductStockUpdate/view.blade.php ENDPATH**/ ?>