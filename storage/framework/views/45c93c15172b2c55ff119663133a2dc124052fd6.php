 
<div class="card-block">
	<div class="view-info">
		<div class="row">
			<div class="col-lg-12">
				<div class="general-info">
					<div class="row">
						<div class="col-lg-12 col-xl-6">
							<div class="table-responsive">
								<table class="table m-0">
									<tbody>
										
										
										<tr>
											<th scope="row">Gin </th>
											<td><?php echo e($product->gin); ?></td>
										</tr>
										<tr>
											<th scope="row">Price </th>
											<td>Rs.<?php echo e($price); ?></td>
										</tr>
										<tr>
											<th scope="row">Name </th>
											<td> <?php echo e($product->product->name); ?>- <?php echo e($product->productGrade->alias); ?>- <?php echo e($product->ratti->rati_standard); ?>+ </td>
										</tr>
									
										
										<tr>
											<th scope="row"> Product</th>
											<td><?php echo e($product->product->alias); ?></td>
										</tr>
										<tr>
											<th scope="row">Grade </th>
											<td><?php echo e($product->productGrade->alias); ?></td>
										</tr>
										<tr>
											<th scope="row">Ratti</th>
											<td><?php echo e($product->ratti->rati_standard); ?>+</td>
										</tr> 
										<tr>
											<th scope="row"> Length</th>
											<td><?php echo e($product->length); ?></td>
										</tr>
										<tr>
											<th scope="row"> Width</th>
											<td><?php echo e($product->width); ?></td>
										</tr>
										<tr>
											<th scope="row"> Depth</th>
											<td><?php echo e($product->depth); ?></td>
										</tr>
										<tr>
											<th scope="row"> Weight</th>
											<td><?php echo e($product->weight.$mg); ?></td>
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
										<tr>
											<th scope="row">UID </th>
											<td><?php echo e($product->id); ?></td>
										</tr>
										
										<tr>
											<th scope="row">Color</th>
											<td><?php echo e($product->color->color); ?></td>
										</tr> 
										<tr>
											<th scope="row">Clarity</th>
											<td><?php echo e($product->clarity->clarity); ?></td>
										</tr> 
										<tr>
											<th scope="row">Origin</th>
											<td><?php echo e($product->origin->origin); ?></td>
										</tr> 
										<tr>
											<th scope="row">Shape</th>
											<td><?php echo e(ucfirst($product->shape->shape)); ?></td>
										</tr> 
										<tr>
											<th scope="row">Specie</th>
											<td><?php echo e($product->specie ? $product->specie->species : ''); ?></td>
										</tr> 
										<tr>
											<th scope="row">SG</th>
											<td><?php echo e($product->sg); ?></td>
										</tr> 
										<tr>
											<th scope="row">Ri</th>
											<td><?php echo e($product->ri); ?></td>
										</tr> 
										<tr>
											<th scope="row">Treatment</th>
											<td><?php echo e($product->treatment->treatment); ?></td>
										</tr> 
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12 col-xl-12">
							<div class="table-responsive">
								<table class="table m-0">
									<tbody>
										<tr>
											<th scope="row">Rate Profile</th>
											<td><?php echo e($product->rateProfile->name); ?></td>
										</tr> 
									</tbody>
								</table>
							</div>
						</div>
					</div>


				</div>
			</div>
		</div>
	</div>
</div>
 

 
 <?php /**PATH E:\newxampp\htdocs\erp2\resources\views/store/ProductStockDetail/view.blade.php ENDPATH**/ ?>