<template>
<div class="row">
   <div class="col-md-12">
      <div class="card">
         <div class="card-footer p-2" style="background-color: #04a9f5">
            <h5 class="text-white m-b-0 text-left d-inline" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;"> Create Opening Stock</h5>
         </div>
         <div class="card-body"> 
               <div class="row">
                  <div class="col col-xl-4 col-md-4">
                     <div class="form-group">
                        <label for="parentId">Account</label>
                        <input name="account" v-bind:value="accountName"   class="form-control" readonly>
                     </div>
                  </div> 
                  <div class="col col-xl-4 col-md-4">
                     <div class="form-group">
                        <label for="parentId">Date</label>
                        <input v-model="date" type="text" class="form-control" readonly>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col col-xl-4 col-md-4">
                     <div class="form-group">
                        <label for="parentId">GIN Number:</label>
                        <input type="number" class="form-control"   placeholder="Enter Gin" v-model="gin" autocomplete="off"
                        v-on:keyup.enter="addGin()">
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
   <div class="col-md-6">
   <div class="card">
       <div class="card-footer p-0" style="background-color: #04a9f5">
    <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Added Products ({{gins.length}})</h5> </div>
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
            <td><button @click="removeProduct(index)">Remove</button></td> 
            <!-- <td><button  class="btn btn-sm btn-danger" onclick="deleteProduct('{{$id}}')">Delete</button></td> -->
         </tr> 
      </tbody> 
   </table>
<h2 v-else class="text-center"><i class="fa fa-inbox"></i>&nbsp; Empty</h2>
</div>
</div> 
    
</div>  


    <!-- Out Of Stock Products -->
   <div class="col-md-3">
   <div class="card">
       <div class="card-footer p-0 bg-warning">
    <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Out Of Stock ({{ notInStockProductsCount }})</h5>
    <!-- <button @click="printOutOfStockProducts()">Print</button>   -->
    </div>
    <div class="card-body">
      <table class="table" id="" style="width:100" v-if="(notInStockProductsCount > 0)">
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
            <td>{{index+1}}</td> 
            <td>{{product}}</td>  
         </tr> 
      </tbody> 
   </table>
   
<h2 v-else class="text-center"><i class="fa fa-inbox"></i>&nbsp; Empty</h2>
</div>
</div> 
    
</div>  
    <!-- Not Exist Products -->
   <div class="col-md-3">
   <div class="card">
       <div class="card-footer p-0 bg-danger">
    <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Not Exist ({{ notExistProductsCount }})</h5>
    <!-- <button @click="printNotExistProducts()">Print</button> -->
     </div>
    <div class="card-body">
      <table  class="table"  style="width:100" v-if="(notExistProductsCount > 0)">
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
   
<h2 v-else class="text-center"><i class="fa fa-inbox"></i>&nbsp; Empty</h2>
</div>
</div> 
    
</div>  
    <!-- Valid Products -->
   <div class="col-md-12" id="exportPdf">
   <div class="card">
       <div class="card-footer p-0 bg-success" >
    <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Valid Products ({{ validProductsCount }})</h5> 
    <!-- <button @click="printValidProducts()">Print</button> -->
    </div>
    <div class="card-body" >
       
   <div class="table-responsive">
<table class="table" id="table_id2" style="width:100"  v-if="(validProductsCount > 0)">
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
            <td>{{product.rattiRate.toFixed(2)}}</td>
            <td>{{product.mrpAmount.toFixed(2)}}</td>
            <td><button  class="btn btn-sm btn-danger" @click="deleteProduct(product.id)">Delete</button></td>
         </tr> 
      </tbody>  
   </table>
   
<h2 v-else class="text-center"><i class="fa fa-inbox"></i>&nbsp; Empty</h2>
</div>
   
   <div class="row">
      <!-- <input type="hidden" name="credit_to" value="{{auth('store')->user()->id}}" id="credit_to11"> -->
      <div class="col col-xl-4 col-md-4 ">
         <div class="form-group">
            <label for="parentId">Comment</label>
            <textarea name="comment" placeholder="enter Comment" v-model="comment"  class="form-control"></textarea>
             <span class="text-danger" v-if="errors.comment">{{errors.comment}}</span>
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
</div> 
    
</div> 
</div> 
 
    

</template> 
 
<script>    
    export default {
        props: ['data','token','accountName','saveGinUrl','routeSaveGins','routeGetAllDetails','routeDeleteProduct','routeOpeningStockSave'],   
        data() {
            return { 
                gin : '',
                gins:[], 
                nextGinId : 1, 
                addedProducts :'',
                outOfStockProducts :'' ,
                notExistProducts : '',
                validProducts : [], 
                validProductsCount : 0, 
                notInStockProductsCount : 0, 
                notExistProductsCount : 0,  
                comment : '',
                date : this.getDate(),
                errors :{ 
                    comment : false
                },
            } 
        },  
        created() {
             this.getAllDetails();
            //  this.getProps(); 
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
            getDate(){
               var today = new Date();
               return today.getDate()+'-'+(today.getMonth() + 1)+'-'+today.getFullYear(); 

            },
            saveGins(){ 
               if(this.gins.length > 0){
               
               let loader = this.$loading.show(); 

                this.axios
                    .post(this.routeSaveGins,{
                       _token : this.token,
                       gins : this.gins,
                    })
                    .then(response => ( 
                        this.getAllDetails()
                    ))
                    .catch(err => loader.hide())
                  .finally(() => loader.hide())
                  }else{
                     swal('Please Add atlease 1 Product');
                  }
            } ,
            getAllDetails(){ 
               let loader = this.$loading.show();
                this.axios
                    .get(this.routeGetAllDetails, this.gins)
                    .then(response => (
                       this.notExistProducts = response.data.notExistProducts,
                        this.outOfStockProducts = response.data.outOfStockProducts,
                        this.validProducts = response.data.validProducts,
					   this.notInStockProductsCount = response.data.notInStockProductsCount,
					   this.notExistProductsCount = response.data.notExistProductsCount,
					   this.validProductsCount = response.data.validProductsCount 
                    ))
                    .catch(err => loader.hide())
                    .finally(() => 
                  //   this.refreshDatatable(),
                    loader.hide())
            } ,
            removeProduct(index){
                this.gins.splice(index, 1);
               
               
            },
            deleteProduct(id){
               let loader = this.$loading.show();
               this.axios
                    .get(this.routeDeleteProduct+`/${id}`)
                    .then(response => (
                         this.getAllDetails()
                    ))
                    .catch(err => loader.hide())
                    .finally(() => loader.hide())
            },
            saveOpeningStock(){ 
                  let loader = this.$loading.show();
                  this.axios
                      .post(this.routeOpeningStockSave,{
                         comment : this.comment
                      })
                      .then(response => {
                         if(response.data.validProducts){
                            swal('There is no any valid product to create Opening Stock');
                         }
                         if(response.data.success){
                            window.location.href = response.data.redirectUrl; 
                         }else{
                            swal('Something Wrong Try Again !');
                            location.reload();
                         }
                      })
                       .catch(err =>{   
                          this.errors.comment = err.response.data.errors.comment;
                          loader.hide()
                      })
                      .finally(() =>  loader.hide())
            },
            
        }
    }
</script>