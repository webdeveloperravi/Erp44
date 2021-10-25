/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
// window.Vue = require('vue');
import Vue from 'vue';
 
import VueAxios from 'vue-axios';
// import VueRouter from 'vue-router';
import axios from 'axios';
// import { routes } from './routes';  
 
import VueLoading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';

import VueGoodTablePlugin from 'vue-good-table'; 
import 'vue-good-table/dist/vue-good-table.css';
 
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */ 
 
  
// axios.defaults.baseURL = 'http://localhost/erp/';
// Vue.mixin({
//     data: function() {
//       return {
//         basicUrl:'http://localhost/erp/'
//       }
//     }
//   })
  
  
// axios.defaults.baseURL = 'https://9gem.net/';
// axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
// Vue.mixin({
//     data: function() {
//       return {
//         basicUrl:'https://9gem.net/'
//       }
//     }
// }) 
  
axios.defaults.baseURL = 'https://erp44.com/'; 
axios.defaults.headers.common['X-XSRF-TOKEN'] = 'window.Laravel.csrfToken';
Vue.mixin({
    data: function() {
      return {
        basicUrl:'https://erp44.com/'
      }
    }
})
   

// Vue.use(VueRouter);
Vue.use(VueAxios, axios); 
Vue.use(VueLoading);
Vue.use(VueGoodTablePlugin);
 
// const router = new VueRouter({
//     mode: 'history',
//     routes: routes
// });
import OpeningStock from './components/OpeningStock/index.vue'; 
import SaleChallan from './components/SaleChallan/index.vue'; 
import ReceiveChallan from './components/ReceiveChallan/index.vue'; 
import SaleInvoice from './components/SaleInvoice/index.vue'; 
import SaleReturn from './components/SaleReturn/index.vue'; 
import SaleOrderPrepare from './components/SaleOrderPrepare/index.vue'; 
import StockVerify from './components/StockVerify/index.vue';  
import StockVerifySecond from './components/StockVerifySecond/index.vue';  
import CustomerInvoice from './components/CustomerInvoice/index.vue';  

 
Vue.component('date-picker', {
  template: `<input class='form-control' v-model='date'/>`,
  props: [ 'dateFormat','date' ],
  mounted: function() {
  var self = this;
  $(this.$el).datepicker({
    dateFormat: this.dateFormat,
    onSelect: function(date) {
      self.$emit('update-date', date);
    }
  });
}

});

const app = new Vue({
    el: '#app',
    // router: router,
    components:{
      OpeningStock : OpeningStock,
      SaleChallan : SaleChallan,
      ReceiveChallan : ReceiveChallan,
      SaleInvoice : SaleInvoice,
      SaleReturn : SaleReturn,
      SaleOrderPrepare : SaleOrderPrepare,
      StockVerify : StockVerify,
      StockVerifySecond : StockVerifySecond,
      CustomerInvoice : CustomerInvoice,
      // StockFilter : StockFilter
    },
    // render: h => h(App),
}); 