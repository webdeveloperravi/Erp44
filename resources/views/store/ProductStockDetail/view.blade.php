 
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
											<td>{{ $product->gin }}</td>
										</tr>
										<tr>
											<th scope="row">Price </th>
											<td>Rs.{{ $price }}</td>
										</tr>
										<tr>
											<th scope="row">Name </th>
											<td> {{ $product->product->name }}- {{ $product->productGrade->alias }}- {{ $product->ratti->rati_standard }}+ </td>
										</tr>
									
										
										<tr>
											<th scope="row"> Product</th>
											<td>{{ $product->product->alias }}</td>
										</tr>
										<tr>
											<th scope="row">Grade </th>
											<td>{{ $product->productGrade->alias }}</td>
										</tr>
										<tr>
											<th scope="row">Ratti</th>
											<td>{{ $product->ratti->rati_standard }}+</td>
										</tr> 
										<tr>
											<th scope="row"> Length</th>
											<td>{{ $product->length }}</td>
										</tr>
										<tr>
											<th scope="row"> Width</th>
											<td>{{ $product->width }}</td>
										</tr>
										<tr>
											<th scope="row"> Depth</th>
											<td>{{ $product->depth }}</td>
										</tr>
										<tr>
											<th scope="row"> Weight</th>
											<td>{{ $product->weight.$mg }}</td>
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
											<td>{{ $product->id }}</td>
										</tr>
										
										<tr>
											<th scope="row">Color</th>
											<td>{{ $product->color->color }}</td>
										</tr> 
										<tr>
											<th scope="row">Clarity</th>
											<td>{{ $product->clarity->clarity  }}</td>
										</tr> 
										<tr>
											<th scope="row">Origin</th>
											<td>{{ $product->origin->origin   }}</td>
										</tr> 
										<tr>
											<th scope="row">Shape</th>
											<td>{{ ucfirst($product->shape->shape)   }}</td>
										</tr> 
										<tr>
											<th scope="row">Specie</th>
											<td>{{  $product->specie ? $product->specie->species : ''  }}</td>
										</tr> 
										<tr>
											<th scope="row">SG</th>
											<td>{{ $product->sg   }}</td>
										</tr> 
										<tr>
											<th scope="row">Ri</th>
											<td>{{ $product->ri   }}</td>
										</tr> 
										<tr>
											<th scope="row">Treatment</th>
											<td>{{ $product->treatment->treatment   }}</td>
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
											<td>{{ $product->rateProfile->name   }}</td>
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
 

 
 