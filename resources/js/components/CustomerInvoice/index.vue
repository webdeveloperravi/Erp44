<template>
<div>
   <div class="row">
      <div class="col-md-12">
         <div class="card">
            <div class="card-footer p-2" style="background-color: #04a9f5">
               <h5 class="text-white m-b-0 text-left d-inline" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;"> Customer Invoice</h5>
            </div>
            <div class="card-body">
               <div class="row">
                  <div class="col col-xl-4 col-md-3">
                     <div class="form-group">
                        <label for="parentId">Enter Customer Phone:</label>
                        <input type="number" class="form-control" v-model="phone" v-on:keyup.enter="findCustomer()" autocomplete="new-password">
                     </div>
                  </div>
                  <div class="col col-xl-4 col-md-4">
                     <div class="form-group">
                        <label for="parentId" class="invisible d-block">Hidden</label>
                        <button class="btn btn-sm btn-dark" @click="findCustomer()">Find</button>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-md-12" v-if="customer">
         <div class="card">
            <div class="card-footer p-2" style="background-color: #04a9f5">
               <h5 class="text-white m-b-0 text-left d-inline" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;"> Customer Details</h5>
            </div>
            <div class="card-body"> 
                <h1>{{ customer.name}}</h1>
                <h1>{{ customer.email}}</h1>
                <h1>{{ customer.phone}}</h1>
            </div>
         </div>
      </div>
      <div class="col-md-12" v-else>
         <div class="card">
            <div class="card-footer p-2" style="background-color: #04a9f5">
               <h5 class="text-white m-b-0 text-left d-inline" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;"> Customer Details</h5>
            </div>
            <div class="card-body"> 
                <div class="col-xl-4 col-md-6 col-12 mb-1">
              <div class="form-group">
                <label for="basicInput">Name</label>
                <input v-model="formCustomer.name" type="text" class="form-control"  placeholder="Customer Name" />
              </div>
            </div> 
                <div class="col-xl-4 col-md-6 col-12 mb-1">
              <div class="form-group">
                <label for="basicInput">Phone</label>
                <input v-model="formCustomer.phone" type="number" class="form-control" autocomplete="new-password"/>
              </div>
            </div>  
            <div class="col-xl-4 col-md-6 col-12 mb-1">
              <div class="form-group">
                <label for="basicInput">Email</label>
                <input v-model="formCustomer.email" type="email" class="form-control"  placeholder="Email"  />
              </div>
            </div>  
             <div class="col col-xl-4 col-md-4">
                     <div class="form-group">
                        <label for="parentId" class="invisible d-block">Hidden</label>
                        <button class="btn btn-sm btn-dark" @click="saveCustomer()">Save Customer</button>
                     </div>
                  </div>
            </div>
         </div>
      </div>
      <div class="col-md-12">
         <div class="card">
             <div class="card-footer p-2" style="background-color: #04a9f5">
                 <h5 class="text-white m-b-0 text-left d-inline" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Customer Invoice</h5>
             </div>
             <div class="card-body"> 
                          <div class="row">
                         <div class="col col-xl-4 col-md-3">
                             <div class="form-group">
                                 <label for="parentId">Enter GIN Number:</label>
                                 <input type="number" class="form-control" v-model="gin" v-on:keyup.enter="addGin()">
                             </div>
                         </div> 
                         <div class="col col-xl-4 col-md-4">
                  <div class="form-group">
                     <label for="parentId" class="invisible d-block">Hidden</label>
                     <button class="btn btn-sm btn-dark" @click="addGin()">Add</button>
                  </div>
               </div>  
                        
                     </div>  
                      <div class="row">
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
               <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Added Products ({{gins.length}})</h5>
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
      <!-- Valid Products -->
      <div class="col-md-12 " id="exportPdf ">
         <div class="card ">
            <div class="card-footer p-0 bg-success ">
               <h5 class="text-white m-b-0 text-left " style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px; ">Valid Products ({{ validProductsCount }})</h5>
            </div>
            <div class="card-body ">
               <table class="table" style="width:100 "  >
                   
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
                        <td>{{product.productStockRatti}}</td>
                        <td>{{product.rattiRate}}</td>
                        <td>{{product.mrpAmount}}</td>
                        <td><button  class="btn btn-sm btn-danger" @click="deleteProduct(product.id)">Delete</button></td>
                     </tr>
                     <tr class="text-left">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Total</td>
                        <td>{{totalAmount }}</td>
                        <td></td>
                     </tr>
                  </tbody>
               </table>
               <!-- <h2 v-else class="text-center "><i class="fa fa-inbox "></i>&nbsp; Empty</h2> -->
            </div>
         </div>
      </div>
       
      <div class="col-md-12">
         <div class="card">
            <div class="card-footer p-2" style="background-color: #04a9f5">
               <h5 class="text-white m-b-0 text-left d-inline" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Payment to Complete Order</h5>
            </div>
              <div class="col-md-3">
             
          </div> 
           
            <div class="card-body"> 
                  <div class="col-xl-4 col-md-6 col-12 mb-1">
             <div class="form-group">
                <label for="parentId">Payment Mode</label>
                <select  class="col-sm-12" v-model="formPayment.paymentMode" @change='getPaymentAccounts()'> 
                   <option value="0" selected>Select Mode</option>
                   <option v-for="mode in paymentModes" v-bind:value="mode.id" :key="mode.id">{{mode.name }}</option> 
                </select>
             </div>
            </div> 
                <div class="col-xl-4 col-md-6 col-12 mb-1">
             <div class="form-group">
                <label for="parentId">To Payment Account</label>
                <select  class="col-sm-12" v-model="formPayment.toAccount"> 
                   <option value="0" selected>Select Account</option>
                   <option v-for="account in paymentAccounts" v-bind:value="account.id" :key="account.id">{{account.name }}</option> 
                </select>
             </div>
              
            </div>  
             <div class="col-xl-4 col-md-6 col-12 mb-1">
              <div class="form-group">
                <label for="basicInput">Amount</label>
                <input v-model="formPayment.amount" type="text" class="form-control"  placeholder="Customer Name" />
              </div>
            </div>  
             <div class="col col-xl-4 col-md-4">
                     <div class="form-group">
                        <label for="parentId" class="invisible d-block">Hidden</label>
                        <button class="btn btn-sm btn-dark" @click="proceedPayment()">Proceed Payment</button>
                     </div>
                  </div>
            </div>
         </div>
      </div>
      <!-- <div class="col-md-12">
         <div class="card">
             <div class="card-footer p-2" style="background-color: #04a9f5">
                 <h5 class="text-white m-b-0 text-left d-inline" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;"> Issue Sale Invoice</h5>
             </div>
             <div class="card-body">
                 <div class="row">
                      <div class="col col-xl-3 col-md-3">
                         <div class="form-group">
         <label for="parentId">Select Store</label>
         <select class=" col-sm-12 form-control" v-model="storeId"> 
         <option value="0">Select Store</option>
         <option v-for="store in stores" v-bind:value="store.id" :key="store.id">{{store.company_name }} - {{store.head_office_address.city.name}}</option> 
         </select>
                     <span class="text-danger" v-if="errors.store">{{errors.store}}</span>
         </div>
                     </div> 
                     <div class="col col-xl-3 col-md-3">
                         <div class="form-group"> 
                             <label for="parentId">Date</label> 
                         <date-picker  @update-date="updateDate" date-format="yy-mm-dd" v-once v-bind:date='date'></date-picker>
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
         <button class="btn btn-sm btn-inverse float-right form-control " type="button" v-on:click="saveSaleInvoice()">Save</button>
                         </div>
                     </div> 
                     </div> 
             </div>
         </div>
         </div>  -->
   </div>
</div>
</template> 
<script>      
   export default {
	props: [
		'routeFindCustomer',
		'routeCreateCustomer',
		'routeSaveCustomer',
		'routeSaveGins',
		'routePaymentCreate',
		'routePaymentSave',
		'routeGetPaymentAccounts',
		'routeGetAllDetails',
		'routeSavePayment',
		'routePlaceOrder',
      'paymentModes', 
	],
	data() {
		return {
			gin: '',
			gins: [],
			nextGinId: 1,
			storeId: 0,
			addedProducts: {},
			validProducts: {},
			validProductsCount: 0,
			phone: '',
			formCustomer: {
				name: '',
				phone: '',
				email: ''
			},
			formPayment: {
				toAccount: 0,
				amount: '',
            paymentMode:0
			},
			paymentAccounts: {},
			customer: false,
         totalAmount:''

		}
	},
	created() {
		console.log(this.paymentModes);
	},
	methods: {
		findCustomer() {
			let loader = this.$loading.show();
			this.axios
				.post(this.routeFindCustomer, {
					phone: this.phone
				})
				.then(response => {
					this.customer = response.data.customer;
					if (!response.data.customer) {
						this.formCustomer.phone = this.phone
					}
				})
				.finally(() => loader.hide())
		},
		saveCustomer() {
			let loader = this.$loading.show();
			this.axios
				.post(this.routeSaveCustomer, {
					customer: this.formCustomer
				})
				.then(response => {
					this.phone = this.formCustomer.phone;
					this.findCustomer();
				})
				.finally(() => loader.hide())
		},
		addGin: function () {
			if (this.gin.length > 0) {
				if (this.gins.some(data => data.gin == this.gin)) {
					this.gin = '';
				} else {

					this.gins.push({
						id: this.nextGinId++,
						gin: this.gin
					});
					this.gin = ''
				}
			}

		},
		removeProduct(index) {
			this.gins.splice(index, 1);
		},
		saveGins() {
			if (this.gins.length > 0) {

				let loader = this.$loading.show();
				this.axios
					.post(this.routeSaveGins, {
						gins: this.gins,
					})
					.then(response => (
						this.getAllDetails()
					))
					.finally(() => loader.hide())
			} else {
				swal('Plead Add atlease 1 Product');
			}
		},
      deleteProduct(id) {
			let loader = this.$loading.show();
			this.axios
				.get(this.routeDeleteProduct + `/${id}`)
				.then(response => (
					this.getAllDetails()
				))
				.catch(err => loader.hide())
				.finally(() => loader.hide())
		},
		proceedPayment() {
			let loader = this.$loading.show();
			this.axios
				.post(this.routePaymentSave, {
					customer: this.formPayment,
               customerId : this.customer.id
				})
				.then(response => {
					this.placeOrder();
               alert(response.data.msg)
				})
				.finally(() => loader.hide())
		},
		placeOrder() {
			let loader = this.$loading.show();
			this.axios
				.post(this.routePlaceOrder, {
               // customer: this.formPayment,
               customerId : this.customer.id
				})
				.then(response => {
               alert(response.data.msg);
               location.reload();
				})
				.finally(() => loader.hide())
		},
		getAllDetails() {
			let loader = this.$loading.show();
			this.axios
				.get(this.routeGetAllDetails)
				.then(response => (

					this.validProducts = response.data.validProducts,
					this.totalAmount = response.data.totalAmount


				))
				.catch(err => loader.hide())
				.finally(() => loader.hide())
		},
		getPaymentAccounts() {
			let loader = this.$loading.show();
			this.axios
				.get(this.routeGetPaymentAccounts+`/${this.formPayment.paymentMode}`)
				.then(response => {
					this.paymentAccounts = response.data;

				})
				.catch(err => loader.hide())
				.finally(() => loader.hide())
		},
	}
}
</script>