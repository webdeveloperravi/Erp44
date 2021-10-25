<?php 
function amountFormat($amount = false)
{
    if($amount){
        return number_format((float)$amount, 2, '.', '');
    }else{
        return "0";
    }
}

function dateFormat($date = false)
{
   if($date){
       return Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->isoFormat('DD-MM-YYYY');
   }else{
       return "";
   }
}

function warehousePageTitle(){
    $str = str_replace('-',' ',Request::path());
    $str = str_replace('warehouse/',' ',$str);  
    return ucwords($str);
}

function adminPageTitle(){
    $str = str_replace('-',' ',Request::path());
    $str = str_replace('admin/',' ',$str);  
    return ucwords($str);
}

function storePageTitle(){
    $str = str_replace('-',' ',Request::path());
    $str = str_replace('store/',' ',$str);  
    return ucwords($str);
}

