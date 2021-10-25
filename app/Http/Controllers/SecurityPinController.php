<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SecurityPinController extends Controller
{
    public function regenerateSecurityPin(Request $request){
       
          dd($request->all());
    }
}
