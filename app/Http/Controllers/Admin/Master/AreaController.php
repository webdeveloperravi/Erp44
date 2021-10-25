<?php

namespace App\Http\Controllers\Admin\Master;

use Validator;
use Illuminate\Http\Request;  
use App\Http\Controllers\Controller;
use App\Model\Admin\Organization\Area;
use App\Model\Admin\Organization\Zone;

class AreaController extends Controller
{
    
    public function index($zoneId)
    {    
        $areas = Area::where('zone_id',$zoneId)->get();
        $zone = Zone::find($zoneId);
        return view('admin.amaster.area.all',compact('areas','zoneId','zone'));
    }

   
    public function create($zoneId)
    {    
        $zone = Zone::find($zoneId);
        return view('admin.amaster.area.create',compact('zoneId','zone'));
    }

  
      protected function store(Request $request)
    {      
          
 
          $validator = Validator::make($request->all(), [
            'name' => 'required', 
            'alias' => 'required',
            'description' => 'required', 
          ]);

          if($validator->passes()){
  
           $area = Area::create([
               'name' => $request->name,
               'alias' => $request->alias,
               'description' => $request->description, 
               'zone_id' => $request->zoneId,
           ]); 

          return response()->json(['success'=> true,'zoneId'=>$request->zoneId ],200);
        }else{
         $keys = $validator->errors()->keys();
     $vals  = $validator->errors()->all();
     $errors = array_combine($keys,$vals);
    
    return response()->json(['errors'=>$errors]);
     }

   } 
    public function edit($areaId)
    {   
        $area = Area::find($areaId);
        return view('admin.amaster.area.edit',compact('area','areaId'));
    }
 
    public function update(Request $request)
    {
        
         $validator = Validator::make($request->all(), [
            'name' => 'required', 
            'alias' => 'required',
            'description' => 'required', 
          ]);

          if($validator->passes()){
           $area = Area::where('id',$request->areaId)->first();
           $area->update([
            'name' => $request->name,
               'alias' => $request->alias,
               'description' => $request->description,  
           ]);

          return response()->json(['success'=> true,'zoneId'=>$area->zone_id],200);
        }else{
         $keys = $validator->errors()->keys();
     $vals  = $validator->errors()->all();
     $errors = array_combine($keys,$vals);
    
    return response()->json(['errors'=>$errors]);
     }
    } 
}
