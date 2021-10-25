 
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
											<th scope="row">GIN </th>
											<td>{{ $timelines[0]->productStock->gin }}</td>
										</tr>
										<tr>
											<th scope="row"> Product</th>
											<td>{{ $timelines[0]->productStock->product->name }}</td>
										</tr>
										<tr>
											<th scope="row">Name </th>
											<td> {{ $timelines[0]->productStock->product->name }}- {{ $timelines[0]->productStock->productGrade->alias }}- {{ $timelines[0]->productStock->ratti->rati_standard }}+ </td>
										</tr>
									
									</tbody>
								</table>
							</div>
						</div> 
						<div class="col-lg-12 col-xl-6">
							<div class="table-responsive">
								<table class="table">
									<tbody>
										@php
										$data = App\Helpers\StoreHelper::getProductGradeRattiRattiRateMrpAmount($timelines[0]->productStock);
									@endphp
										<tr>
											<th scope="row">Ratti </th>
											<td>{{ $data['productStockRatti'] ?? "" }}</td>
										</tr>
										<tr>
											<th scope="row">Rate </th>
											<td>{{ $data['rattiRate'] ?? "" }}</td>
										</tr>
										<tr>
											<th scope="row">MRP </th>
											<td>{{ $data['mrpAmount'] ?? "" }}</td>
										</tr>
										<tr>
											<th scope="row">&nbsp; </th>
											<td>({{ $data['rattiRate']?? "" }} X {{ $data['productStockRatti'] ?? ""  }})</td>
										</tr>
										{{-- <tr>
											<th scope="row">Ratti</th>
											<td>{{ $timelines[0]->product_unit_qty }}+</td>
										</tr>  --}} 
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

<div class="row">
	<div class="col-sm-12"> 
			<div class="card-header">
				<h5>Timeline</h5> </div>
			<div class="card-block">
				<div class="main-timeline">
					<div class="cd-timeline cd-container">
						@foreach ($timelines as $timeline)
						@if ($loop->last)
						<div class="cd-timeline-block">
							<div class="cd-timeline-icon bg-primary"> <i class="icofont icofont-ui-file"></i> </div>
							<div class="cd-timeline-content card_main"> <img src="../files/assets/images/timeline/img1.jpg" class="img-fluid width-100" alt="" />
								<div class="p-20">
									<div class="timeline-details mb-1">
										<i class="icofont icofont-ui-calendar"></i><span>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $timeline->created_at)->isoFormat('DD-MM-YYYY') }}</span> 
									</div>
									<h6 class="mb-2">Voucher No.{{ $timeline->ledger->voucher_number }}</h6>
									<h6 class="mb-2">Voucher Type : {{ $timeline->ledger->voucher->name ?? "" }}</h6> 
									<h6 class="mb-2">To Company: {{ $timeline->ledger->storeReceipt->name ?? "" }}</h6>
								</div>  
							</div>
						</div>
						@else
							<div class="cd-timeline-block">
							<div class="cd-timeline-icon bg-primary"> <i class="icofont icofont-ui-file"></i> </div>
							<div class="cd-timeline-content card_main"> <img src="../files/assets/images/timeline/img1.jpg" class="img-fluid width-100" alt="" />
								<div class="p-20">
									<div class="timeline-details mb-1">
										<i class="icofont icofont-ui-calendar"></i><span>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $timeline->created_at)->isoFormat('DD-MM-YYYY') }}</span> 
									</div>
									<h6 class="mb-2">Voucher No.{{ $timeline->ledger->voucher_number }}</h6>
									<h6 class="mb-2">Voucher Type : {{ $timeline->ledger->voucher->name ?? "" }}</h6>
									@if ($timeline->ledger->userIssue->type == 'lab' || $timeline->ledger->userIssue->type == 'org')
									<h6 class="mb-2">From Company : {{ $timeline->ledger->userIssue->company_name ?? "" }}</h6>
									@elseif ($timeline->ledger->userIssue->type == 'user')
									<h6 class="mb-2">From Company : {{ $timeline->ledger->userIssue->parentStore->company_name ?? "" }}</h6>
									@endif
									<h6 class="mb-2">From User : {{ $timeline->ledger->userIssue->name ?? "" }}</h6>

									
									@if ($timeline->ledger->userReceipt->type == 'lab' || $timeline->ledger->userReceipt->type == 'org')
									<h6 class="mb-2">To Company : {{ $timeline->ledger->userReceipt->company_name ?? "" }}</h6>
									@elseif ($timeline->ledger->userReceipt->type == 'user')
									<h6 class="mb-2">To Company : {{ $timeline->ledger->userReceipt->parentStore->company_name ?? "" }}</h6>
									@endif
									<h6 class="mb-2">To User : {{ $timeline->ledger->userReceipt->name ?? "" }}</h6>
								</div>  
							</div>
							</div>
						@endif
							@endforeach 
					</div>
				</div>
			</div> 
	</div>
</div>