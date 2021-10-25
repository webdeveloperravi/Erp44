<template>
 <div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-footer p-2" style="background-color: #04a9f5">
                    <h5 class="text-white m-b-0 text-left d-inline" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;"> Create Sale Return Enter Gin</h5>
                </div>
                <div class="card-body"> 
                         <div class="row">
                            <div class="col col-xl-4 col-md-3">
                                <div class="form-group">
                                    <label for="parentId">GIN Number:</label>
                                    <input type="number" class="form-control" v-model="gin" v-on:keyup.enter="addGin()">
                                </div>
                            </div> 
                            <div class="col-md-12">
                            <div class="form-group">
                                <label for="parentId">&nbsp;</label>
                                <button class="btn btn-primary btn-sm" v-on:click="saveGins()">Filter Data to Preview Enteries</button>
                            </div>
                        </div>
                        </div> 
                </div>
            </div>
        </div>
        
        <!-- Not Exist Products -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-footer p-0" style="background-color: #04a9f5">
                    <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Added Products</h5>
                </div>
                <div class="card-body">
                    <table  class="table " v-if="gins.length"   style="width:100">
                        <thead>
                            <tr>
                                <th>Sr.</th>
                                <th>Gin</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody> 
                           <tr class="text-center" v-for="(gin,index) in gins" :key="index"> 
								<td>{{index+1}}</td> 
								<td>{{gin.gin}}</td>
								<td><button @click="removeProduct(index)">Remove</button></td>  
							</tr> 
                        </tbody>
                    </table>
                    <h2 v-else class=" text-center "><i class="fa fa-inbox "></i>&nbsp; Empty</h2>
                </div>
            </div>

        </div>


        <!-- Out Of Stock Products -->
        <div class="col-md-3 ">
            <div class="card ">
                <div class="card-footer p-0 bg-warning ">
                    <h5 class="text-white m-b-0 text-left " style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px; ">Not in Stock Products</h5><button>Print</button>
                </div>
                <div class="card-body ">
                    
                    <table class="table " style="width:100">
                        <thead>
                            <tr>
                                <!-- <th>Store UID</th> -->
                                <th>Sr.</th>
                                <th>Gin</th>
                                <!-- <th>Action</th> -->
                            </tr>
                        </thead>
                        <tbody>
                              <tr class="text-center" v-for="(product,index) in notInStockProducts" :key="index"> 
									<td>{{product.id}}</td> 
								<td>{{product.gin}}</td>  
							</tr> 
                        </tbody>
                    </table>
                    <!-- <h2 v-else class=" text-center "><i class="fa fa-inbox "></i>&nbsp; Empty</h2>    -->
                </div>
            </div>

        </div>
        <!-- Not Exist Products -->
        <div class="col-md-3 ">
            <div class="card ">
                <div class="card-footer p-0 bg-danger ">
                    <h5 class="text-white m-b-0 text-left " style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px; ">Not Exist Products</h5><button>Print</button>
                </div>
                <div class="card-body ">
                    <table class="table " id=" " style="width:100 " >
                        <thead>
                            <tr> 
                                <th>Sr.</th>
                                <th>Gin</th> 
                            </tr>
                        </thead>
                        <tbody>
                              <tr class="text-center" v-for="(product,index) in notExistProducts" :key="index"> 
								<td>{{product.id}}</td> 
								<td>{{product.gin}}</td>  
							</tr> 
                        </tbody>
                    </table>

                    <!-- <h2 v-else class="text-center "><i class="fa fa-inbox "></i>&nbsp; Empty</h2> -->
                </div>
            </div>

        </div>
        <!-- Valid Products -->
        <div class="col-md-12 " id="exportPdf ">
            <div class="card ">
                <div class="card-footer p-0 bg-success ">
                    <h5 class="text-white m-b-0 text-left " style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px; ">Valid Products</h5> <button>Print</button>
                </div>
                <div class="card-body ">
    <table class="table" style="width:100 " >
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
            <th>Action</th>
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
            <td><button  class="btn btn-sm btn-danger" @click="deleteProduct(product.id)">Delete</button></td>
         </tr> 
      </tbody> 
    </table>
    <!-- <h2 v-else class="text-center "><i class="fa fa-inbox "></i>&nbsp; Empty</h2>                 -->

                    

                </div>
            </div>

        </div> 
            <div class="col-md-12">
                <div class="card">
                    <div class="card-footer p-2" style="background-color: #04a9f5">
                        <h5 class="text-white m-b-0 text-left d-inline" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;"> Issue Sale Return</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col col-xl-3 col-md-3">
                                <div class="form-group">
							<label for="parentId">Select Store</label>
							<select class=" col-sm-12 form-control" v-model="storeId" v-on:change="getAccounts()"> 
							<option value="0">Select Store</option>
							<option v-for="store in stores" v-bind:value="store.id" :key="store.id">{{store.company_name}}</option> 
					    	</select>
                            <span class="text-danger" v-if="errors.store">{{errors.store}}</span>
							</div>
                            </div>
                            <div class="col col-xl-3 col-md-3">
                                <div class="form-group">
                                    <label for="parentId">Select Account</label>
							<select class=" col-sm-12 form-control" v-model="accountId"> 
							<option value="0" selected>Select Account</option>
							<option v-for="account in accounts" v-bind:value="account.id" :key="account.id">{{account.name}}</option> 
						</select>
                            <span class="text-danger" v-if="errors.account">{{errors.account}}</span>
                                </div>
                            </div> 
                            <div class="col col-xl-3 col-md-3">
                                <div class="form-group">
                                    <label for="parentId">Date</label>
                                    <input type="text" v-model="date" class="form-control" readonly=""  >
                                </div>
                            </div>
                        </div> 
						<div class="row">
                            <div class="col col-xl-4 col-md-4 ">
                                <div class="form-group ">
                                <label for="parentId ">Comment</label>
                                <textarea name="comment " placeholder="enter Comment " class="form-control " v-model="comment"></textarea>
                                <span class="text-danger" v-if="errors.comment">{{errors.comment}}</span>
                                    
                                </div>
                            </div>
                            <div class="col col-xl-4 col-md-4 ">
                                <div class="form-group ">
								<label for="parentId ">&nbsp;&nbsp;&nbsp;</label>
								<button class="btn btn-sm btn-inverse float-right form-control " type="button" v-on:click="saveSaleReturn()">Save</button>
                                </div>
                            </div> 
                            </div> 
                    </div>
                </div>
            </div> 

    </div>



</div>
</template> 
<script>  
// import validProducts from './validProducts' ;  
    export default { 
        components : {
        //   'validProducts' : validProducts, 
        },
        data() {
            return { 
                gin : '',
                gins:[], 
				nextGinId : 1, 
				stores :[],
				storeId : 0, 
				accounts :[],
                accountId : 0, 
                date :"",
                addedProducts :{},
                notInStockProducts :{} , 
                notExistProducts :{} , 
                validProducts : {}, 
                comment : '',   
                errors :{
                    account : false,
                    store : false,
                    comment : false
                }
            }
        },  
        created() { 
             this.getStores(); 
             this.getAllDetails(); 
             this.setDate();
        }, 
        methods: { 
			getStores:function(){
			    	this.axios.get('/store/sale-return-get-stores')
				.then(response => { 
				    this.stores = response.data.stores;
				})
				.catch(err => console.log(err))
				.finally(() => this.loading = false)
			},
			getAccounts:function(){
			    	this.axios.get(`/store/sale-return-get-accounts/${this.storeId}`)
				.then(response => { 
				    this.accounts = response.data.accounts;
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
				.post(`/store/sale-return-save-gins`, {
					gins : this.gins 
					}
				)
				.then(response => ( 
					this.getAllDetails()
				))
				.catch(err => console.log(err))
				.finally(() => this.loading = false)
	     	},  
            getAllDetails(){ 
                this.axios
                    .get('/store/sale-return-get-all-details')
                    .then(response => ( 
                        
                       this.notExistProducts = response.data.notExistProductsSaleReturn,
                       this.notInStockProducts = response.data.notInStockProductsSaleReturn,
					   this.validProducts = response.data.validProducts
                    ))
                    .catch(err => console.log(err))
                    .finally(() => this.loading = false)
            } ,
            removeProduct(index){
                this.gins.splice(index, 1); 
			},
			 saveSaleReturn(){
            this.errors.store=false;
            this.errors.account=false;
               this.axios
                      .post('/store/sale-return-save-return',{
						 comment : this.comment,
                         account:this.accountId,
                         store:this.storeId
                      })
                      .then(response => {
                         if(response.data.redirectUrl){
                            window.location.href = response.data.redirectUrl; 
                         }
                      })
                      .catch(err =>{ 
                          this.errors.store = err.response.data.errors.store;
                          this.errors.account = err.response.data.errors.account;
                          this.errors.comment = err.response.data.errors.comment;
                      })
                      .finally(() => this.loading = false)
            },
            
            deleteProduct(id){
               this.axios
                    .get(`/store/sale-return-delete-product/${id}`)
                    .then(response => (
                         this.getAllDetails()
                    ))
                    .catch(err => console.log(err))
                    .finally(() => this.loading = false)
            },
            setDate(){ 
                // this.date = now();
                  
            }
        }
    }
</script>