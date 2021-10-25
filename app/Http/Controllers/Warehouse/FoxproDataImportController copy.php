<?php

namespace App\Http\Controllers\Warehouse;

use XBase\TableReader;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Model\DataMigration\TblItem;
use App\Model\DataMigration\TblIfvalue;
use Illuminate\Support\Facades\Validator;
use App\Model\Admin\Master\ProductMWeightRange;
use App\Model\Warehouse\InvoiceDetailGradeProduct;
use App\Model\Admin\Master\ProductGradeRateProfile;

class FoxproDataImportController extends Controller
{
    public function index()
    { 
        return view('warehouse.FoxproDataImport.index');
    }

    // Step 1
    public function storeTables(Request $request)
    {    
        sleep(2);
        if($request->hasFile('tbl_item') && $request->hasFile('tbl_ifvalue')){
            
            $tblItemFile = $request->tbl_item;
            $tblIfvalueFile = $request->tbl_ifvalue;
            $tblItemFileName = $tblItemFile->getClientOriginalName();
            $tblIfvalueFileName = $tblIfvalueFile->getClientOriginalName(); 
          if($tblItemFileName == 'item.dbf' && $tblIfvalueFileName == 'ifvalue.dbf'){

            // try{
            //     DB::beginTransaction();
                $this->importItemTable($tblItemFile);
                $this->importIfValueTable($tblIfvalueFile);
                // DB::commit(); 
            // }catch(\Exception $e){       
            //     DB::rollback();
            //     dd($e); 
            // } 
            return response()->json(['success'=>true]);
          }else{
            return response()->json(['invalid_files'=>true]);
          } 
        }else{
            return response()->json(['empty_files'=>true]);
        }
    }

    public function importItemTable($file)
    {   
        $oldItemId = TblItem::max('item_id') ?? 0;
        if($oldItemId == 0 ){
            try{
                DB::beginTransaction(); 
                TblItem::create([
                    'item_id' => 1,
                    'iname' => 'Natural Yellow Sapphire',
                    'icode' => 11213151,
                    'erp_product_id' => 9
                ]);
                TblItem::create([
                    'item_id' => 2,
                    'iname' => 'Natural Yellow Sapphire',
                    'icode' => 11213152,
                    'erp_product_id' => 9
                ]);
                DB::commit(); 
            }catch(\Exception $e){       
                DB::rollback();
                dd($e); 
            }
            
        }

        $table = new TableReader($file);
        $records = [];
        while ($record = $table->nextRecord()) {
            // if($record->itemid <= 40000){
                // if($record->itemid > 40000 && $record->itemid <= 80000){
                if($record->itemid > $oldItemId){
                    
                    TblItem::insert( [
                        'item_id' => $record->itemid,
                        'iname' => $record->iname,
                        'icode' => $record->icode,
                        'igroupid' => $record->igroupid
                    ]);
                $records[] = [
                    'item_id' => $record->itemid,
                    'iname' => $record->iname,
                    'icode' => $record->icode,
                    'igroupid' => $record->igroupid
                ];
            } 
        }
        if(count($records) > 0){
            // try{
            //     DB::beginTransaction(); 
                foreach($records as $data){ 

                    TblItem::insert($data);
                }
            //     DB::commit(); 
            // }catch(\Exception $e){       
            //     DB::rollback();
            //     dd($e); 
            // }  
        }
    }

    public function importIfValueTable($file)
    {   
        $oldItemId = TblIfvalue::max('item_id') ?? 0;
        if($oldItemId == 0 ){
            try{
                DB::beginTransaction(); 
                TblIfvalue::create([
                    'item_id' => 1,
                    'length' => 12.18,
                    'width' => 08.54 ,
                    'depth' => 05.82 ,
                    'weight' => 1280 ,
                    'ri' => 1,
                    'sg' => 1,
                    'color' => 'Light Yellow',
                    'shape' => 'Rectangular Cushion',
                    'clarity' => 'Transparent',
                    'treatment' => null,
                    'picture' => "",
                    'origin' => null,
                    'specie' => null,
                    'grade' => 'N',
                    'label_id' => null,
                    'seal_1' => null,
                    'seal_2' => null,
                ]); 
                TblIfvalue::create([
                    'item_id' => 2,
                    'length' => '11.53' ,
                    'width' => '8.40',
                    'depth' => '5.46 ',
                    'weight' => 1000 ,
                    'ri' => 1,
                    'sg' => 1,
                    'color' => 'Light Yellow',
                    'shape' => 'Rectangular Cushion',
                    'clarity' => 'Transparent',
                    'treatment' => null,
                    'picture' => "",
                    'origin' => null,
                    'specie' => null,
                    'grade' => 'N',
                    'label_id' => null,
                    'seal_1' => null,
                    'seal_2' => null,
                ]); 
                DB::commit(); 
            }catch(\Exception $e){       
                DB::rollback();
                dd($e); 
            }
            
        }
        $table = new TableReader($file);
        $records = [];

        $color_data  = color::pluck('name','id');
        while ($record = $table->nextRecord()) {
            // if($record->itemid <= 40000){
                // if($record->itemid > 40000 && $record->itemid <= 80000){
                if($record->itemid > $oldItemId){
                    if(!empty($color_data[$record->field7])){
                        $color_id = $color_data[$record->field7];// 

                    }else{
                        $color =  new Color;
                      $color->name = $record->field7;
                      $color->save();
                      $color_id = $color->id;
                    }

                    
                   $check = Color::select(['id','name'])->whereName($record->field7);
                   if($check->exists()){
                        $color_id = $check->first()->id;
                   }else{
                      $color =  new Color;
                      $color->name = $record->field7;
                      $color->save();
                      $color_id = $color->id;
                   }
                $records[] = [
                    'item_id' => $record->itemid,
                    'length' => $record->field1,
                    'width' => $record->field2,
                    'depth' => $record->field3,
                    'weight' => $record->field4,
                    'ri' => $record->field5,
                    'sg' => $record->field6,
                    'color' =>$color_id,// $record->field7,
                    'shape' => $record->field8,
                    'clarity' => $record->field9,
                    'treatment' => null,
                    'picture' => $record->field11,
                    'origin' => null,
                    'specie' => null,
                    'grade' => $record->field19,
                    'label_id' => $record->field16,
                    'seal_1' => $record->field17,
                    'seal_2' => $record->field18,
                ];
            } 
        }  
        if(count($records) > 0){
            // try{
            //     DB::beginTransaction(); 
                foreach($records as $data){ 
                    TblIfvalue::insert($data);
                }
            //     DB::commit(); 
            // }catch(\Exception $e){       
            //     DB::rollback();
            //     dd($e); 
            // }
        }
    }
    
    //Step 2
    public function getLeftPRoductsToReplaceWithErpId()
    {   
        if(TblItem::count() > 0 && TblIfvalue::count() > 0){
        $product = TblItem::where('erp_product_id',null)->count() ?? 0;
        $color = TblIfvalue::where('color','REGEXP','[A-Za-z-]+')->count() ?? 0; 
        $shape = TblIfvalue::where('shape','REGEXP','[A-Za-z-]+')->count() ?? 0; 
        $clarity = TblIfvalue::where('clarity','REGEXP','[A-Za-z-]+')->count() ?? 0; 
        $treatment = TblIfvalue::where('treatment',null)->count() ?? 0;
        $origin = TblIfvalue::where('origin',null)->count() ?? 0; 
        $specie = TblIfvalue::where('specie',null)->count() ?? 0; 
        $grade = TblIfvalue::where('grade','REGEXP','[A-Za-z.]+')->count() ?? 0; 
        $ratti = TblIfvalue::where('ratti_id',null)->count() ?? 0; 
        $rateProfile = TblIfvalue::where('rate_profile_id',null)->count() ?? 0; 
        
        return view('warehouse.FoxproDataImport.leftPRoductsToReplaceWithErpId',compact(
            'product', 'color', 'shape', 'clarity', 'treatment', 'origin', 'specie', 'grade','ratti','rateProfile'
        ));
         }else{

             $product = 0;
             $color =  0; 
             $shape = 0; 
             $clarity = 0; 
             $treatment = 0;
             $origin =  0;
             $specie =  0; 
             $grade =  0; 
             $ratti =  0; 
             $rateProfile =   0; 
             return view('warehouse.FoxproDataImport.leftPRoductsToReplaceWithErpId',compact(
                 'product', 'color', 'shape', 'clarity', 'treatment', 'origin', 'specie', 'grade','ratti','rateProfile'
             ));
         }
     
    }

    public function columnsReplaceWithErpId(Request $request)
    { 
        if($request->has('columns')){
            
        try{
            DB::beginTransaction();

            //Product
            if(in_array(1,$request->columns))
            {
                $this->updateProduct();
            }
            //Color
            if(in_array(2,$request->columns))
            {
                $this->updateColor();
            }
            //Shape
            if(in_array(3,$request->columns))
            {
                $this->updateShape();
            }
            //Clarity
            if(in_array(4,$request->columns))
            {
                $this->updateClarity();
            }
            //Treatment
            if(in_array(5,$request->columns))
            {
                $this->updateTreatment();
            }
            //Origin
            if(in_array(6,$request->columns))
            {
                $this->updateOrigin();
            }
            //Specie
            if(in_array(7,$request->columns))
            {
                $this->updateSpecie();
            }
            //Grade
            if(in_array(8,$request->columns))
            {
                $this->updateGrade();
            }
            //Ratti
            if(in_array(9,$request->columns))
            {
                $this->updateRatti();
            }
            //Rate Profile
            if(in_array(10,$request->columns))
            {
                $this->updateRateProfile();
            }

            DB::commit(); 
        }catch(\Exception $e){       
             DB::rollback();
             dd($e); 
        } 
        return response()->json(['success'=>true]);
        }else{
        return response()->json(['invalid_selection'=>true]);
        
        }
    }
    
    public function updateProduct()
    {
            TblItem::where('igroupid',1)->update(['erp_product_id'=> 9]);
            TblItem::where('igroupid',3)->update(['erp_product_id'=> 11]);
            TblItem::where('igroupid',5)->update(['erp_product_id'=> 1]);
            TblItem::where('igroupid',6)->update(['erp_product_id'=> 4]);
            TblItem::where('igroupid',7)->update(['erp_product_id'=> 3]);
            TblItem::where('igroupid',8)->update(['erp_product_id'=> 7]);
            TblItem::where('igroupid',9)->update(['erp_product_id'=> 6]);
            TblItem::where('igroupid',10)->update(['erp_product_id'=> 5]);
            TblItem::where('igroupid',11
            
            )->update(['erp_product_id'=> 2]);
            TblItem::where('igroupid',12)->update(['erp_product_id'=> 13]);
            TblItem::where('igroupid',13)->update(['erp_product_id'=> 8]);
            TblItem::where('igroupid',14)->update(['erp_product_id'=> 12]);
            TblItem::where('igroupid',25)->update(['erp_product_id'=> 8]);
            TblItem::where('igroupid',50)->update(['erp_product_id'=> 14]);
        TblItem::where('igroupid',24)->update(['erp_product_id'=> 15]); 
    }

    public function updateColor()
    {
            TblIfvalue::where('color','-')->update(['color'=> 20]);
            TblIfvalue::where('color','620')->update(['color'=> 23]);
            TblIfvalue::where('color','Blue')->update(['color'=> 7]);
            TblIfvalue::where('color','Bluish Yellow')->update(['color'=> 15]);
            TblIfvalue::where('color','Dark Blue')->update(['color'=> 9]);
            TblIfvalue::where('color','Dark Brown')->update(['color'=> 27]);
            TblIfvalue::where('color','Dark Green')->update(['color'=> 12]);
            TblIfvalue::where('color','Dark Reddish Yellow')->update(['color'=> 24]);
            TblIfvalue::where('color','Dark Yellow')->update(['color'=> 6]);
            TblIfvalue::where('color','Golden')->update(['color'=> 3]);
            TblIfvalue::where('color','Green')->update(['color'=> 10]);
            TblIfvalue::where('color','Greenish Yellow')->update(['color'=> 37]);
            TblIfvalue::where('color','Greyish White')->update(['color'=> 18]);
            TblIfvalue::where('color','J')->update(['color'=> 47]);
            TblIfvalue::where('color','Light Blue')->update(['color'=> 8]);
            TblIfvalue::where('color','Light Green')->update(['color'=> 11]);
            TblIfvalue::where('color','Light Greyish White')->update(['color'=> 18]);
            TblIfvalue::where('color','Light Pink')->update(['color'=> 2]);
            TblIfvalue::where('color','Light Yellow')->update(['color'=> 21]);
            TblIfvalue::where('color','Off White')->update(['color'=> 20]);
            TblIfvalue::where('color','Peacock Black')->update(['color'=> 4]);
            TblIfvalue::where('color','Pink')->update(['color'=> 16]);
            TblIfvalue::where('color','Pinkish Blue')->update(['color'=> 25]);
            TblIfvalue::where('color','Pomegranate Red')->update(['color'=> 23]);
            TblIfvalue::where('color','Purple Blue')->update(['color'=> 36]);
            TblIfvalue::where('color','Red')->update(['color'=> 13]);
            TblIfvalue::where('color','Reddish Blue')->update(['color'=> 26]);
            TblIfvalue::where('color','Reddish Yellow')->update(['color'=> 24]);
            TblIfvalue::where('color','White')->update(['color'=> 20]); 
            TblIfvalue::where('color','White Transparent')->update(['color'=> 22]);
            TblIfvalue::where('color','Yellow')->update(['color'=> 5]);
            TblIfvalue::where('color','Yellowish Blue')->update(['color'=> 19]); 
    }

    public function updateShape()
    {
            // TblIfvalue::where('shape','Octagonal')->first()->update(['shape' => 9]);
            TblIfvalue::where('shape','Octagonal')->update(['shape' => 9]);
            TblIfvalue::where('shape','Oval')->update(['shape' => 1]);
            TblIfvalue::where('shape','Rectangular Cushion')->update(['shape' => 2]);
            TblIfvalue::where('shape','Round')->update(['shape' => 6]);
            TblIfvalue::where('shape','Rectangular')->update(['shape' => 22]);
            TblIfvalue::where('shape','Capsule')->update(['shape' => 7]);
            TblIfvalue::where('shape','Triangular')->update(['shape' => 24]);
            TblIfvalue::where('shape','Round Beads')->update(['shape' => 25]);
            TblIfvalue::where('shape','Square Cushion')->update(['shape' => 3]);
            TblIfvalue::where('shape','Pear')->update(['shape' => 10]);
            TblIfvalue::where('shape','Rhomboid')->update(['shape' => 26]);
            TblIfvalue::where('shape','Square')->update(['shape' => 20]);
            TblIfvalue::where('shape','Statue')->update(['shape' => 5]);
            TblIfvalue::where('shape','Irregular')->update(['shape' => 23]);
            TblIfvalue::where('shape','Oval Cabochon')->update(['shape' => 8]);
            TblIfvalue::where('shape','Round Cabochon')->update(['shape' => 8]);
            TblIfvalue::where('shape','Round Brilliant')->update(['shape' => 27]); 
    }

    public function updateClarity()
    {
            TblIfvalue::where('clarity','Translucent')->update(['clarity' => 2]); 
            TblIfvalue::where('clarity','Transparent')->update(['clarity' => 1]); 
            TblIfvalue::where('clarity','Opaque')->update(['clarity' => 3]); 
            TblIfvalue::where('clarity','Translucnet')->update(['clarity' => 2]); 
            TblIfvalue::where('clarity','Translucent')->update(['clarity' => 2]); 
            TblIfvalue::where('clarity','Oapque')->update(['clarity' => 3]); 
            TblIfvalue::where('clarity','Translucent Red')->update(['clarity' => 2]); 
            TblIfvalue::where('clarity','Translcuent')->update(['clarity' => 2]); 
            TblIfvalue::where('clarity','Translucent`')->update(['clarity' => 2]); 
            TblIfvalue::where('clarity','Transparnet')->update(['clarity' => 1]); 
            TblIfvalue::where('clarity','Opauqe')->update(['clarity' => 3]); 
            TblIfvalue::where('clarity','.Translucent')->update(['clarity' => 2]); 
            TblIfvalue::where('clarity','.Opaque')->update(['clarity' => 3]); 
            TblIfvalue::where('clarity','-')->update(['clarity' => 1]); 
            TblIfvalue::where('clarity','VS1')->update(['clarity' => 11]);
    }

    public function updateTreatment()
    {
        // TblIfvalue::where('treatment',null)->get()->each(function($record){
        //     $record->update(['treatment'=> 3]);
        // }); 
        TblIfvalue::where('treatment',null)->update(['treatment'=> 3]);
    }


    public function updateOrigin()
    {   
        TblIfvalue::whereHas('item',function($q){
            $q->where('erp_product_id',2);
        })->update(['origin'=>1]);

        TblIfvalue::whereHas('item',function($q){
                    $q->whereIn('erp_product_id',[3,13]);
        })->update(['origin'=>8]);

        TblIfvalue::whereHas('item',function($q){
            $q->where('erp_product_id',4);
        })->update(['origin'=> 4]);

        TblIfvalue::whereHas('item',function($q){
            $q->whereIn('erp_product_id',[5,7]);
        })->update(['origin' => 17]);

        TblIfvalue::whereHas('item',function($q){
            $q->where('erp_product_id',14);
        })->update(['origin' => 6]);

        // TblIfvalue::whereHas('item',function($q){
        //     $q->where('erp_product_id',6);
        // })->update(['origin'=>]);

        TblIfvalue::whereHas('item',function($q){
            $q->whereIn('erp_product_id',[11,1,12,8,9]);
        })->update(['origin'=>2]);
 
    }

    public function updateSpecie()
    {     
         TblIfvalue::whereHas('item',function($q){
                    $q->where('erp_product_id',2);
         })->update(['specie'=>4]);

         TblIfvalue::whereHas('item',function($q){
                    $q->whereIn('erp_product_id',[3,13]);
         })->update(['specie'=>6]);
          
         TblIfvalue::whereHas('item',function($q){
            $q->where('erp_product_id',4);
        })->update(['specie'=>2]);
          
         TblIfvalue::whereHas('item',function($q){
            $q->where('erp_product_id',5);
        })->update(['specie'=>5]);

        TblIfvalue::whereHas('item',function($q){
            $q->whereIn('erp_product_id',[6,14]);
        })->update(['specie'=>3]);

        TblIfvalue::whereHas('item',function($q){
            $q->whereIn('erp_product_id',[7,11,1,12,8,9]);
        })->update(['specie'=>1]);
    }

    public function updateGrade()
    { 
            TblIfvalue::where('grade','N')->update(['grade' => 1]);    
            TblIfvalue::where('grade','F')->update(['grade' => 2]);    
            TblIfvalue::where('grade','P')->update(['grade' => 3]);    
            TblIfvalue::where('grade','SP1')->update(['grade' => 4]);    
            TblIfvalue::where('grade','SP2')->update(['grade' => 5]);    
            TblIfvalue::where('grade','SP3')->update(['grade' => 6]);    
            TblIfvalue::where('grade','SP4')->update(['grade' => 7]);    
            TblIfvalue::where('grade','SP5')->update(['grade' => 8]);    
            TblIfvalue::where('grade','SP6')->update(['grade' => 9]);    
            TblIfvalue::where('grade','SP7')->update(['grade' => 10]);    
            TblIfvalue::where('grade','SP8')->update(['grade' => 11]);    
            TblIfvalue::where('grade','SP9')->update(['grade' => 12]);    
            TblIfvalue::where('grade','SP10')->update(['grade' => 13]);    
            TblIfvalue::where('grade','SP11')->update(['grade' => 14]);  
    }

    public function updateRatti()
    {   
        TblIfvalue::select('id','ratti_id','weight')->where('ratti_id',null)->get()->each(function($ifValue){
            $ratti = ProductMWeightRange::select('id')->where('from','<=',$ifValue->weight)->where('to','>=',$ifValue->weight)->first() ?? false;
            if($ratti){
                $ifValue->update(['ratti_id' => $ratti->id]);
            }
        });   
    }

    public function updateRateProfile()
    {   
        TblIfvalue::with('item')->where('rate_profile_id',null)->get()->each(function($ifValue){
            $rateProfile = ProductGradeRateProfile::where(['product_id'=> $ifValue->item->product_id,'grade_id'=> $ifValue->grade,'status'=> 1])
                                                   ->select('rate_profile_id','id')
                                                   ->first() ?? false;
            if($rateProfile){
                $ifValue->update(['rate_profile_id' => $rateProfile->id]);
            }
        });   
 
    }
    
    // Step 3
    public function leftProductStockImport()
    {
        $oldItemId = InvoiceDetailGradeProduct::max('itemid') ?? 0;
        $itemsCount = TblItem::with('ifValue')->where('item_id','>',$oldItemId)->count();
        
        return view('warehouse.FoxproDataImport.leftStockToImportStep3',compact('itemsCount'));
    } 

    public function insertProductsInProductStock()
    {   
        if(\App\Helpers\Helper::dataImportStep2Status()){

        
        $oldItemId = InvoiceDetailGradeProduct::max('itemid') ?? 0;
        $items = TblItem::with('ifValue')->where('item_id','>',$oldItemId)->get();
        if($items->count() > 0){
            try{
                DB::beginTransaction(); 
                foreach($items as $item){
                  InvoiceDetailGradeProduct::create([
                      'itemid' => $item->item_id ?? "",
                      'iname' => $item->iname ?? "",
                      'gin' => $item->icode ?? "",
                      'product_id' => $item->erp_product_id ?? "",
                      'length' => $item->ifValue->length ?? "",
                      'width' => $item->ifValue->width ?? "",
                      'depth' => $item->ifValue->depth ?? "",
                      'weight' => $item->ifValue->weight ?? "",
                      'ri' => $item->ifValue->ri ?? "",
                      'sg' => $item->ifValue->sg ?? "",
                      'color_id' => $item->ifValue->color ?? "",
                      'shape_id' => $item->ifValue->shape ?? "",
                      'clarity_id' => $item->ifValue->clarity ?? "",
                      'treatment_id' => $item->ifValue->treatment ?? "",
                      'primary_image' => $item->ifValue->picture ?? "",
                      'origin_id' => $item->ifValue->origin ?? "",
                      'specie_id' => $item->ifValue->specie ?? "",
                      'grade_id' => $item->ifValue->grade ?? 0,
                      'label_id' => $item->ifValue->label_id ?? "" ,
                      'seal_1' => $item->ifValue->seal_1 ?? "" ,
                      'seal_2' => $item->ifValue->seal_2 ?? "" ,
                      'ratti_id' => $item->ifValue->ratti_id ?? "" ,
                      'rate_profile_id' => $item->ifValue->rate_profile_id ?? "" ,
                  ]);
                }
                DB::commit(); 
                return response()->json(['success'=>true]); 
            }catch(\Exception $e){       
                DB::rollback();
                dd($e); 
            }
            
        }
    }else{
        return response()->json(['failed'=>true]); 
    }
    }
}
