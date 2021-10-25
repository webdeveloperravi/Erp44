<template>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-footer p-2" style="background-color: #04a9f5">
				<h5 class="text-white m-b-0 text-left d-inline" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Stock Verify Second</h5> </div>
			<div class="card-body">
            <div class="row">
                 <div class="col col-xl-3 col-md-3">
                                <div class="form-group">
							<label for="parentId">Select Store</label>
							<select class=" col-sm-12 form-control" v-model="storeId" v-on:change="getAccounts()">  
                        <option value="0" selected>Select Store</option>
							<option v-for="store in stores" v-bind:value="store.id" :key="store.id">{{store.company_name }} - {{store.head_office_address.city.name}}</option> 
					    	</select>
                            <!-- <span class="text-danger" v-if="errors.store">{{errors.store}}</span> -->
							</div>
                            </div>
                            <div class="col col-xl-3 col-md-3">
                                <div class="form-group"> 
                                   <label for="parentId">Select Account</label>
							<select class=" col-sm-12 form-control" v-model="accountId"> 
							<option value="0" selected>Select Account</option>
							<option v-for="account in accounts" v-bind:value="account.id" :key="account.id">{{account.name}}</option> 
						</select>
                            <!-- <span class="text-danger" v-if="errors.account">{{errors.account}}</span> -->
                                </div>
                            </div> 
            </div>
				<div class="row">
					<div class="col-xl-3 col-md-6 col-12 mb-1">
						<div class="form-group">
							<label for="parentId">Select Product</label>
							<select class="form-control" v-model="product">
								<option value="0">All Products</option>
								<option v-for="(product,index) in products" :key="index" v-bind:value="product.id">{{product.alias}}</option>
							</select>
						</div>
					</div>
					<div class="col-xl-3 col-md-6 col-12 mb-1">
						<div class="form-group">
							<label for="parentId">Select Grade</label>
							<select class="form-control" v-model="grade">
								<option value="0">All Grades</option>
								<option v-for="grade in grades" :key="grade.id" v-bind:value="grade.id">{{grade.alias}}</option>
							</select>
						</div>
					</div>
					<div class="col-xl-3 col-md-6 col-12 mb-1">
						<div class="form-group">
							<label for="parentId">Select Ratti</label>
							<select class="form-control" v-model="ratti">
								<option value="0">All Rattis</option>
								<option v-for="ratti in rattis" :key="ratti.id" v-bind:value="ratti.id">{{ratti.rati_standard}}+</option>
							</select>
						</div>
					</div>
					<div class="col-xl-3 col-md-6 col-12 mb-1">
						<div class="form-group">
							<label for="parentId" class="invisible d-block">Hidden</label>
							<button class="btn btn-sm btn-dark" @click="getProducts()">Get Products</button>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col col-xl-4 col-md-4">
						<div class="form-group">
							<label for="parentId">GIN Number:</label>
							<input type="number" class="form-control" placeholder="Enter Gin" v-model="gin" autocomplete="off" v-on:keyup.enter="addGin()"> </div>
					</div>
					
					<div class="col col-xl-4 col-md-4">
						<div class="form-group">
							<label for="parentId" class="invisible d-block">Hidden</label>
							<button class="btn btn-sm btn-dark" @click="addGin()">Add</button>
						</div>
					</div>
				</div>
            <!-- <div class="row">
               <div class="col col-xl-6 col-md-6"> 
                 <span> <input type="checkbox"  v-model="wantNotScannedProducts"> Get Not Scanned Products </span>
					</div>
            </div>
				<div class="row">
					<div class="col col-xl-4 col-md-4">
						<div class="form-group">
							<label for="parentId" class="invisible d-block">Hidden</label>
							<button class="btn btn-sm btn-success" @click="saveGins()">Filter Data to Preview Enteries</button>
						</div>
					</div>
				</div> -->
			</div>
		</div>
	</div>
	<!-- In Stock Products -->
	<div class="col-md-4" >
		<div class="card">
			<div class="card-footer p-0 "  style="background-color: #04a9f5">
				<h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Un-Verified Products ({{ leftProducts.length }})</h5> </div>
			<div class="card-body">
				<table v-if="(leftProducts.length > 0)" class="table" style="width:100">
					<thead>
						<tr>
							<th>Sr.</th>
							<th>Gin</th>
							<!-- <th>Action</th> -->
						</tr>
					</thead>
					<tbody>
						<tr class="text-center" v-for="(gin,index) in leftProducts" :key="index">
							<!-- <td>{{product}}</td>  -->
							<td>{{index+1}}</td>
							<td>{{gin}}</td>
							<!-- <td>
								<button @click="removeProduct(index)">Remove</button>
							</td> -->
						</tr>
					</tbody>
				</table>
				<h2 v-else class="text-center"><i class="fa fa-inbox"></i>&nbsp; Empty</h2> </div>
		</div>
	</div> 
   
	<!-- Not Exist Products -->
	<div class="col-md-4" >
		<div class="card">
			<div class="card-footer p-0 bg-success">
				<h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Verified Products ({{scannedProducts.length}})</h5> </div>
			<div class="card-body">
				<table v-if="(scannedProducts.length > 0)" class="table" style="width:100">
					<thead>
						<tr>
							<th>Sr.</th>
							<th>Gin</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<tr class="text-center" v-for="(gin,index) in scannedProducts" :key="index">
							<!-- <td>{{product}}</td>  -->
							<td>{{index+1}}</td>
							<td>{{gin.gin}}</td>
							<td>
								<button @click="removeProduct(index)">Remove</button>
							</td>
						</tr>
					</tbody>
				</table>
				<h2 v-else class="text-center"><i class="fa fa-inbox"></i>&nbsp; Empty</h2> </div>
		</div>
	</div>  
	<!-- In-Valid Products -->
	<div class="col-md-4" >
		<div class="card">
			<div class="card-footer p-0 bg-danger">
				<h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Excess Products  ({{ invalidProducts.length }}) </h5> </div>
			<div class="card-body">
				<table v-if="(invalidProducts.length > 0)" class="table" style="width:100">
					<thead>
						<tr>
							<th>Sr.</th>
							<th>Gin</th>
						</tr>
					</thead>
					<tbody>
						<tr class="text-center" v-for="(product,index) in invalidProducts" :key="index">
							<td>{{index+1}}</td>
							<td>{{product.gin}}</td>
						</tr>
					</tbody>
				</table>
				<h2 v-else class="text-center "><i class="fa fa-inbox "></i>&nbsp; Empty</h2> </div>
		</div>
	</div>
</div>   
</template> 
 
<script>    
    export default {
        props: ['stores','routeGetAccounts','products','grades','rattis','routeGetProducts','routeSaveGins'],  
        data() {
            return {  
               product:'0',
               grade:'0',
               ratti:'0',
               gin : '',
               gins:[], 
               nextGinId : 1, 
               storeId : 0, 
               accounts :[],
               accountId : 0,
               wantNotScannedProducts:false, 
                leftProducts :'' ,
                scannedProducts :[] , 
                invalidProducts : [],   
            }
        },   
        methods: {  
            getAccounts:function(){
                this.axios.get(this.routeGetAccounts+`/${this.storeId}`)
				.then(response => { 
                    this.accountId = 0;
                    this.accounts = response.data.accounts;
				})
				.catch(err => console.log(err))
				// .finally(() => loader.hide())
            },
            addGin:function(){
               if(this.gin.length > 0){
                  if(this.scannedProducts.some(data => data == this.gin)){
                     this.gin =''; 
                  }else{
                     if(this.leftProducts.some(data => data == this.gin)){
                           
                         this.scannedProducts.push({
                        id: this.nextGinId++,
                        gin: this.gin
                     });
                  this.leftProducts.splice((_.invert(this.leftProducts))[this.gin], 1);
                     }else{
                        this.invalidProducts.push({
                        id: this.nextGinId++,
                        gin: this.gin
                     });
                     }
                   
                  ; // => 'foo'
                  // for(var product in this.inStockProducts) { 
                  //    if(this.inStockProducts[product].gin == this.gin) { 
                  //          this.inStockProducts.splice(product,1);
                  //    }
                  // }
                  this.gin =''
                  }
               } 
            }, 
            removeProduct(index){
                this.gins.splice(index, 1); 
			   },
            saveGins(){ 
               // if(this.gins.length > 0){
               // let loader = this.$loading.show();
               //  this.axios
               //      .post(this.routeSaveGins,{
               //         product:this.product,
               //         grade : this.grade,
               //         ratti:this.ratti,
               //         gins : this.gins,
               //         userId:this.accountId,
               //         wantNotScannedProducts:this.wantNotScannedProducts
               //      })
               //      .then(response => (  
               //          alert('saab')
               //      ))
               //      .catch(err => loader.hide())
               //    .finally(() => loader.hide())
               //    }else{
               //       swal('Plead Add atlease 1 Product');
               //    }
            } ,
            getProducts(){  
               let loader = this.$loading.show();
                this.axios
                    .post(this.routeGetProducts,{
                       product:this.product,
                       grade : this.grade,
                       ratti:this.ratti,
                       userId:this.accountId
                    })
                    .then(response => (   
                           this.leftProducts = response.data.leftProducts,
                             this.scannedProducts = [],
                             this.invalidProducts = []
                    ))
                    .catch(err => loader.hide())
                  .finally(() => loader.hide()) 
            }, 
        },
        watch:{
         //   inStockProducts:function(records){
         //      if(records.length > 0){
         //         this.view.inStockProducts = true;
         //      }else{
         //         this.view.inStockProducts = false;
         //      }
         //   }, 
        }
    }
</script>
 