<template>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-footer p-2" style="background-color: #04a9f5">
				<h5 class="text-white m-b-0 text-left d-inline" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;"> Create Sale Challan</h5> </div>
			<div class="card-body">
				<form>
					<div class="row">
						 <div class="col col-xl-3 col-md-3"> 
                     <div class="form-group">
                     <label for="parentId">Select Store</label> 
                     <select class=" col-sm-12" v-model="account" v-on:change="getManagers()"> 
                        <option value="0" selected>Select Store</option>
                        <option v-for="account in accounts" v-bind:value="account.id" :key="account.id">{{account.name}}</option> 
                     </select>
                  </div>
                  </div>
						 <div class="col col-xl-3 col-md-3"> 
                     <div class="form-group">
                     <label for="parentId">Select Account</label> 
                     <select class=" col-sm-12" v-model="manager"> 
                        <option value="0" selected>Select Account</option>
                        <option v-for="manager in managers" v-bind:value="manager.id" :key="manager.id">{{manager.name}}</option> 
                     </select>
                  </div>
                  </div>
						<div class="col col-xl-4 col-md-4">
							<div class="form-group">
								<label for="parentId">Opening Stock Number</label>
								<input type="text" name="number" class="form-control" readonly=""> </div>
						</div>
						<div class="col col-xl-4 col-md-4">
							<div class="form-group">
								<label for="parentId">Date</label>
								<input type="text" name="challanNumber" class="form-control"> </div>
						</div>
					</div>
					<div class="row">
						<div class="col col-xl-4 col-md-3">
							<div class="form-group">
								<label for="parentId">GIN Number:</label>
								<input type="number" class="form-control" placeholder="Enter Gin" v-model="gin" autocomplete="off" v-on:keyup.enter="addGin()"> </div>
						</div>
						<!-- <div class="col col-xl-4 col-md-3">
                     <div class="form-group">
                        <label for="parentId">&nbsp;</label> 
                        <button type="button" class="btn btn-primary btn-sm form-control" @click="saveGins()">Save Gins</button>
                     </div>
                  </div> --></div>
				</form>
			</div>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<label for="parentId">&nbsp;</label>
			<button class="btn btn-primary btn-sm" @click="saveGins()">Filter Data to Preview Enteries</button>
		</div>
	</div>
	<!-- Not Exist Products -->
	<div class="col-md-6">
		<div class="card">
			<div class="card-footer p-0" style="background-color: #04a9f5">
				<h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Added Products</h5> </div>
			<div class="card-body">
				<table v-if="gins.length" class="table" id="" style="width:100">
					<thead>
						<tr>
							<th>Sr.</th>
							<th>Gin</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<tr class="text-center" v-for="(gin,index) in gins" :key="index">
							<!-- <td>{{product}}</td>  -->
							<td>{{index+1}}</td>
							<td>{{gin.gin}}</td>
							<td>
								<button @click="removeProduct(index)">Remove</button>
							</td>
							<!-- <td><button  class="btn btn-sm btn-danger" onclick="deleteProduct('{{$id}}')">Delete</button></td> -->
						</tr>
					</tbody>
				</table>
				<h2 v-else class="text-center"><i class="fa fa-inbox"></i>&nbsp; Empty</h2> </div>
		</div>
	</div>
	<!-- Out Of Stock Products -->
	<div class="col-md-3">
		<div class="card">
			<div class="card-footer p-0 bg-warning">
				<h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Out Of Stock Products</h5>
				<button @click="printOutOfStockProducts()">Print</button>
			</div>
			<div class="card-body">
				<table class="table" id="" style="width:100">
					<thead>
						<tr>
							<!-- <th>Store UID</th> -->
							<th>Sr.</th>
							<th>Gin</th>
							<!-- <th>Action</th> -->
						</tr>
					</thead>
					<tbody>
						<tr class="text-center" v-for="(product,index) in outOfStockProducts" :key="index">
							<!-- <td>{{product}}</td>  -->
							<td>{{index+1}}</td>
							<td>{{product}}</td>
							<!-- <td><button  class="btn btn-sm btn-danger" onclick="deleteProduct('{{$id}}')">Delete</button></td> -->
						</tr>
					</tbody>
				</table>
				<!-- <h2 v-else class="text-center"><i class="fa fa-inbox"></i>&nbsp; Empty</h2> --></div>
		</div>
	</div>
	<!-- Not Exist Products -->
	<div class="col-md-3">
		<div class="card">
			<div class="card-footer p-0 bg-danger">
				<h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Not Exist Products</h5>
				<button @click="printNotExistProducts()">Print</button>
			</div>
			<div class="card-body">
				<table class="table" id="" style="width:100">
					<thead>
						<tr>
							<!-- <th>Store UID</th> -->
							<th>Sr.</th>
							<th>Gin</th>
							<!-- <th>Action</th> -->
						</tr>
					</thead>
					<tbody>
						<tr class="text-center" v-for="(product,index) in notExistProducts" :key="index">
							<!-- <td>{{product}}</td>  -->
							<td>{{index+1}}</td>
							<td>{{product}}</td>
							<!-- <td><button  class="btn btn-sm btn-danger" onclick="deleteProduct('{{$id}}')">Delete</button></td> -->
						</tr>
					</tbody>
				</table>
				<!-- <h2 v-else class="text-center"><i class="fa fa-inbox"></i>&nbsp; Empty</h2> --></div>
		</div>
	</div>
	<!-- Valid Products -->
	<div class="col-md-12" id="exportPdf">
		<div class="card">
			<div class="card-footer p-0 bg-success">
				<h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Valid Products</h5>
				<button @click="printValidProducts()">Print</button>
			</div>
			<div class="card-body">
				<table class="table" id="" style="width:100">
					<thead>
						<tr>
							<th>UID</th>
							<th>Gin</th>
							<th>Product</th>
							<th>Grade</th>
							<th>Ratti</th>
							<th>Ex-Ratti</th>
							<th>Rate</th>
							<th>Ex-Amount</th>
							<!-- <th>Action</th> -->
						</tr>
					</thead>
					<tbody>
						<tr class="text-left" v-for="(product,index) in validProducts" :key="index">
							<td>{{product.id}}</td>
							<td>{{product.gin}}</td>
							<td>{{product.product}}</td>
							<td>{{product.grade}}</td>
							<td>{{product.ratti}}</td>
							<td>{{product.exactRatti}}</td>
							<td>{{product.exactRate}}</td>
							<td>{{product.exactAmount}}</td>
							<td>
								<button class="btn btn-sm btn-danger" @click="deleteProduct(product.id)">Delete</button>
							</td>
						</tr>
					</tbody>
				</table>
				<div class="row">
					<!-- <input type="hidden" name="credit_to" value="{{auth('store')->user()->id}}" id="credit_to11"> -->
					<div class="col col-xl-4 col-md-4 ">
						<div class="form-group">
							<label for="parentId">Comment</label>
							<textarea name="comment" placeholder="enter Comment" v-model="comment" class="form-control"></textarea>
						</div>
					</div>
					<div class="col col-xl-4 col-md-4 ">
						<div class="form-group">
							<label for="parentId">&nbsp;&nbsp;&nbsp;</label>
							<button class="btn btn-sm btn-inverse float-right form-control" @click="saveOpeningStock()">Save</button>
						</div>
					</div>
				</div>
			</div>
			<!-- <h2 v-else class="text-center py-2"><i class="fa fa-inbox"></i>&nbsp; Empty</h2> --></div>
	</div>
</div>
        
    

</template> 
<script>  
import validProducts from './validProducts' ; 
import jsPDF from 'jspdf'
// import outOfStockProducts from './outOfStockProducts'  ;
// import notExistProducts from './notExistsProducts' ;
    export default {
        props: ['data','csrf_token','authCompanyName','saveGinUrl'], 
        components : {
          'validProducts' : validProducts,
        //   'outOfStockProducts' : outOfStockProducts,
        //   'notExistProducts' : notExistProducts,
        },
        data() {
            return { 
                gin : '',
                gins:[], 
                nextGinId : 1,
                accountName :'',
                addedProducts :'',
                outOfStockProducts :'' ,
                notExistProducts : '',
                validProducts : '', 
                comment : '',
                accounts : '',
                managers : '',
                account : '',
                manager : '',
                
            }
        },  
        created() {
            //  this.getAllDetails();
             this.getAccounts(); 
        }, 
        methods: { 
         //    getProps:function(){
         //      this.axios.get('/store/opening-stock-get-props')
         //    .then(response => {
         //       console.log(response);
         //       this.accountName = response.data.accountName;
         //    })
         //    .catch(err => console.log(err))
         //    .finally(() => this.loading = false)
         //   },
            getAccounts:function(){
              this.axios.get('/store/sale-challan-get-accounts')
            .then(response => {
               console.log(response);
               this.accounts = response.data.accounts;
            })
            .catch(err => console.log(err))
            .finally(() => this.loading = false)
           },
            getManagers:function(){
              this.axios.get(`/store/sale-challan-managers/${this.account}`)
            .then(response => {
               console.log(response.data);
               this.managers = response.data.managers;
            })
            .catch(err => console.log(err))
            .finally(() => this.loading = false)
           },
            addGin:function(){
               if(this.gin.length > 0){
                   this.gins.push({
                   id: this.nextGinId++,
                   gin: this.gin
               });
               this.gin =''
               } 
               
            },
            saveGins(){ 
                this.axios
                    .post('/store/sale-challan-save-gins', this.gins)
                    .then(response => (
                        // this.notExistProducts = response.data.notExistProducts,
                        // this.outOfStockProducts = response.data.outOfStockProducts
                        this.getAllDetails()
                    ))
                    .catch(err => console.log(err))
                  //   .finally(() => this.loading = false)
            },
            getAllDetails(){ 
                this.axios
                    .get('/store/sale-challan-get-all-details', this.gins)
                    .then(response => (
                       this.notExistProducts = response.data.notExistProducts,
                        this.outOfStockProducts = response.data.outOfStockProducts,
                        this.validProducts = response.data.validProducts
                      
                    ))
                    .catch(err => console.log(err))
                    .finally(() => this.loading = false)
            } ,
            removeProduct(index){
                this.gins.splice(index, 1);
               
               
            },
            // deleteProduct(id){
            //    this.axios
            //         .get(`/store/opening-stock-delete-product/${id}`)
            //         .then(response => (
            //              this.getAllDetails()
            //         ))
            //         .catch(err => console.log(err))
            //         .finally(() => this.loading = false)
            // },
            // saveOpeningStock(){
            //    this.axios
            //           .post('/store/opening-stock-save',{
            //              comment : this.comment
            //           })
            //           .then(response => {
            //              if(response.data.redirectUrl){
            //                 window.location.href = response.data.redirectUrl; 
            //              }
            //           })
            //           .catch(err => console.log(err))
            //           .finally(() => this.loading = false)
            // },
            // printNotExistProducts(){
            //    let a= document.createElement('a');
            //          a.target= '_blank';
            //          a.href= this.basicUrl+'store/opening-stock-print-not-exist-products';
            //          a.click();  
            // },
            // printOutOfStockProducts(){
            //    let a= document.createElement('a');
            //          a.target= '_blank';
            //          a.href= this.basicUrl+'store/opening-stock-print-out-of-stock-products';
            //          a.click();  
            // },
            // printValidProducts(){
            //    let a= document.createElement('a');
            //          a.target= '_blank';
            //          a.href= this.basicUrl+'store/opening-stock-print-valid-products';
            //          a.click();  
            // },
            
        }
    }
</script>