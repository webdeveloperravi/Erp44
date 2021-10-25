@extends('layouts.store.app')
@section('css')
    <style>
        th{
            font-weight: 400!important;
        }
        td{
            font-weight: 400!important;
        }
        .vgt-wrap__footer .footer__row-count__label{
            display: none !important;
        }
        .vgt-wrap__footer .footer__row-count__select{
            font-size: 1rem !important;
            font-weight: 400 !important;
        }
        .vgt-wrap__footer{
            font-size: 1rem !important;
            
        }

        </style>    
@endsection
@section('content') 
<div id="app">
  <stock-verify-second 
   v-bind:stores="{{ $stores }}" 
   route-get-accounts="{{route('stockVerifySecond.getAccounts')}}"
   v-bind:products="{{ $products }}" 
  v-bind:grades="{{ $grades }}" v-bind:rattis="{{ $rattis }}"
     route-save-gins="{{ route('stockVerifySecond.saveGins') }}"
     route-get-products="{{ route('stockVerifySecond.getProducts') }}"
  ></stock-verify-second>  
</div>
 {{-- <div class="card" id="form">
   <!--Header ---->
   <div class="card-footer p-0" style="background-color: #04a9f5">
     <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Stock Verify</h5>
    </div>
   <div class="card-body"> 
   
    <div id="productsView"></div>
    <div id="all"></div>
 </div>
 </div> --}}
 {{-- <script>
     'use strict';
 
 //Welcome Message (not for login page)
 function notify(message, type){
     $.growl({
         message: message
     },{
         type: type,
         allow_dismiss: false,
         label: 'Cancel',
         className: 'btn-xs btn-inverse',
         placement: {
             from: 'top',
             align: 'right'
         },
         delay: 2500,
         animate: {
                 enter: 'animated fadeInRight',
                 exit: 'animated fadeOutRight'
         },
         offset: {
             x: 30,
             y: 30
         }
     });
 };

     function getProducts(){
      $.ajax({
         url : "{{ route('stockVerifySecond.getProducts') }}",
         method : "POST",
         data : $("#createForm").serialize(),
         success: function(data){
            $("#productsView").html(data);
         }
      });
   }

   function verify(){
        $.ajax({
         url : "{{ route('stockVerifySecond.verify') }}",
         method : "POST",
         data : $("#verifyForm").serialize(),
         success: function(data){ 
             if(data.success){
              getProducts();
              notify('SuccessFully Added', 'inverse'); 

             }
             if(data.failed){
               notify('Product Belongs To Another Configurations', 'danger');
             }
             if(data.notFound){
              notify('Product Not Found', 'danger');
             }
             
           
         },
      }); 
    }
 </script> --}}
@endsection

