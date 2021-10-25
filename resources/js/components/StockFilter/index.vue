<template>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-footer p-2" style="background-color: #04a9f5">
				<h5 class="text-white m-b-0 text-left d-inline" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Stock Verify</h5> </div>
			<div class="card-body">
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
							<button class="btn btn-sm btn-dark" @click="getProducts()()">Get Products</button>
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
				<div class="row">
					<div class="col col-xl-4 col-md-4">
						<div class="form-group">
							<label for="parentId" class="invisible d-block">Hidden</label>
							<button class="btn btn-sm btn-success" @click="saveGins()">Filter Data to Preview Enteries</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Not Exist Products -->
	<div class="col-md-6" v-if="card.addedProducts">
		<div class="card">
			<div class="card-footer p-0" style="background-color: #04a9f5">
				<h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Added Products ({{gins.length}})</h5> </div>
			<div class="card-body">
				<table v-if="gins.length" class="table" style="width:100">
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
						</tr>
					</tbody>
				</table>
				<h2 v-else class="text-center"><i class="fa fa-inbox"></i>&nbsp; Empty</h2> </div>
		</div>
	</div>
	<!-- In-Valid Products -->
	<div class="col-md-6" v-if="card.invalidProducts">
		<div class="card">
			<div class="card-footer p-0 bg-danger">
				<h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">InValid Products ({{ validProductsCount }})</h5> </div>
			<div class="card-body">
				<table class="table" style="width:100" v-if="view.invalidProducts">
					<thead>
						<tr>
							<th>Sr.</th>
							<th>Gin</th>
						</tr>
					</thead>
					<tbody>
						<tr class="text-center" v-for="(product,index) in invalidProducts" :key="index">
							<td>{{index+1}}</td>
							<td>{{product}}</td>
						</tr>
					</tbody>
				</table>
				<h2 v-else class="text-center "><i class="fa fa-inbox "></i>&nbsp; Empty</h2> </div>
		</div>
	</div>
	<!-- In Stock Products -->
	<div class="col-md-12" v-if="card.inStockProducts">
		<div class="card">
			<div class="card-footer p-0 bg-success">
				<h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">In-Stock Products</h5> </div>
			<div class="card-body p-0">
				<vue-good-table :columns="columns" :rows="inStockProducts" :line-numbers="true" :search-options="{
            enabled: true
         }" :pagination-options="{
            enabled: true,
            mode: 'records',
            perPage: 50, 
            perPageDropdown: [50,70,100,200],  
            nextLabel: 'next',
            prevLabel: 'prev',
            rowsPerPageLabel: 'Rows per page',
            ofLabel: 'of',
            pageLabel: 'page', // for 'pages' mode
            allLabel: 'All', 
         }"> </vue-good-table>
         </div>
		</div>
	</div>
	<!-- Out Of Stock Products -->
	<div class="col-md-12" v-if="card.outOfStockProducts">
		<div class="card">
			<div class="card-footer p-0 bg-warning">
				<h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Out Of Stock Products</h5>
				<!-- <button @click="printOutOfStockProducts()">Print</button>  -->
			</div>
			<div class="card-body p-0">
				<vue-good-table :columns="columns" :rows="outOfStockProducts" :line-numbers="true" :search-options="{
            enabled: true
         }" :pagination-options="{
            enabled: true,
            mode: 'records',
            perPage: 50, 
            perPageDropdown: [50,70,100,200],  
            nextLabel: 'next',
            prevLabel: 'prev',
            rowsPerPageLabel: 'Rows per page',
            ofLabel: 'of',
            pageLabel: 'page', // for 'pages' mode
            allLabel: 'All', 
         }"> </vue-good-table>
			</div>
		</div>
	</div>
	<!-- In Stock Products -->
	<div class="col-md-12" v-if="card.notInStockProducts">
		<div class="card">
			<div class="card-footer p-0 bg-primary">
				<h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Not In-Stock Products</h5> </div>
			<div class="card-body p-0">
				<vue-good-table :columns="columns" :rows="notInStockProducts" :line-numbers="true" :search-options="{
            enabled: true
         }" :pagination-options="{
            enabled: true,
            mode: 'records',
            perPage: 50, 
            perPageDropdown: [50,70,100,200],  
            nextLabel: 'next',
            prevLabel: 'prev',
            rowsPerPageLabel: 'Rows per page',
            ofLabel: 'of',
            pageLabel: 'page', // for 'pages' mode
            allLabel: 'All', 
         }"> </vue-good-table>
			 </div>
		</div>
	</div>
	<!-- In Stock Products -->
	<div class="col-md-12" v-if="card.differentProducts">
		<div class="card">
			<div class="card-footer p-0 bg-secondary">
				<h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Different Products (Without Filter)</h5> </div>
			<div class="card-body p-0">
				<vue-good-table :columns="columns" :rows="differentProducts" :line-numbers="true" :search-options="{
            enabled: true
         }" :pagination-options="{
            enabled: true,
            mode: 'records',
            perPage: 50, 
            perPageDropdown: [50,70,100,200],  
            nextLabel: 'next',
            prevLabel: 'prev',
            rowsPerPageLabel: 'Rows per page',
            ofLabel: 'of',
            pageLabel: 'page', // for 'pages' mode
            allLabel: 'All', 
         }"> 
  </vue-good-table> 
  </div>
		</div>
	</div>
</div>  

</template> 
 
<script>    
    export default {
        props: ['products','grades','rattis'],  
        data() {
            return {  
               product:'0',
               grade:'0',
               ratti:'0',

                gin : '',
                gins:[], 
                nextGinId : 1, 
                
                addedProducts :'',
                inStockProducts :'' ,
                outOfStockProducts :'' ,
                notInStockProducts :'' ,
                differentProducts :'' ,
                invalidProducts : '', 
                view:{
                   inStockProducts:false,
                   outOfStockProducts:false,
                   notInStockProducts:false,
                   differentProducts:false,
                   invalidProducts:false,
                },
                card:{
                   addedProducts:true,
                   inStockProducts:true,
                   outOfStockProducts:true,
                   notInStockProducts:true,
                   differentProducts:true,
                   invalidProducts:true,
                },
                columns: [ 
                   {
                      label:'UID',
                      field : 'id'
                   },
                   {
                      label:'Gin',
                      field : 'gin'
                   },
                   {
                      label:'Product',
                      field : 'product.alias'
                   },
                   {
                      label:'Grade',
                      field : 'product_grade.alias'
                   },
                   {
                      label:'Ratti',
                      field : 'ratti.rati_standard'
                   },  
                ]
            }
        },   
        methods: {  
            addGin:function(){
               if(this.gin.length > 0){
                  if(this.gins.some(data => data.gin == this.gin)){
                     this.gin =''; 
                  }else{
                     this.gins.push({
                     id: this.nextGinId++,
                     gin: this.gin
                  });
                  this.gin =''
                  }
               } 
            }, 
            removeProduct(index){
                this.gins.splice(index, 1); 
			   },
            saveGins(){ 
               if(this.gins.length > 0){
               let loader = this.$loading.show();
                this.axios
                    .post('/store/stock-verify-save-gins',{
                       product:this.product,
                       grade : this.grade,
                       ratti:this.ratti,
                       gins : this.gins
                    })
                    .then(response => ( 
                           this.card.addedProducts = true,
                           this.card.inStockProducts = true,
                           this.card.outOfStockProducts = true,
                           this.card.notInStockProducts = true,
                           this.card.differentProducts = true,
                           this.card.invalidProducts = true,
                           this.inStockProducts = response.data.inStockProducts,
                           this.outOfStockProducts = response.data.outOfStockProducts,
                           this.notInStockProducts = response.data.notInStockProducts,
                           this.invalidProducts = response.data.invalidProducts , 
                           this.differentProducts = response.data.differentProducts  
                    ))
                    .catch(err => loader.hide())
                  .finally(() => loader.hide())
                  }else{
                     swal('Plead Add atlease 1 Product');
                  }
            } ,
            getProducts(){  
               let loader = this.$loading.show();
                this.axios
                    .post('/store/stock-verify-get-products',{
                       product:this.product,
                       grade : this.grade,
                       ratti:this.ratti,
                    })
                    .then(response => ( 
                           this.card.addedProducts = true,
                           this.card.inStockProducts = true,
                           this.card.outOfStockProducts = true,
                           this.card.notInStockProducts = false,
                           this.card.differentProducts = false,
                           this.card.invalidProducts = false,
                           this.inStockProducts = response.data.inStockProducts,
                           this.outOfStockProducts = response.data.outOfStockProducts  
                    ))
                    .catch(err => loader.hide())
                  .finally(() => loader.hide()) 
            } ,
            getAllDetails(){ 
               let loader = this.$loading.show();
                this.axios
                    .get('/store/opening-stock-get-all-details', this.gins)
                    .then(response => (
                       this.notExistProducts = response.data.notExistProducts,
                        this.outOfStockProducts = response.data.outOfStockProducts,
                        this.validProducts = response.data.validProducts
                        
                    ))
                    .catch(err => loader.hide())
                    .finally(() =>  
                    loader.hide())
            } , 
        },
        watch:{
           outOfStockProducts:function(records){
              if(records.length > 0){
                 this.view.outOfStockProducts = true;
              }else{
                 this.view.outOfStockProducts = false;
              }
           },
           notInStockProducts:function(records){
              if(records.length > 0){
                 this.view.notInStockProducts = true;
              }else{
                 this.view.notInStockProducts = false;
              }
           },
           differentProducts:function(records){
              if(records.length > 0){
                 this.view.differentProducts = true;
              }else{
                 this.view.differentProducts = false;
              }
           },
           invalidProducts:function(records){
              if(records.length > 0){
                 this.view.invalidProducts = true;
              }else{
                 this.view.invalidProducts = false;
              }
           },
           inStockProducts:function(records){
              if(records.length > 0){
                 this.view.inStockProducts = true;
              }else{
                 this.view.inStockProducts = false;
              }
           },
        }
    }
</script>
 