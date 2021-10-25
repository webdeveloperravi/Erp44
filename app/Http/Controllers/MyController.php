<?php
   
namespace App\Http\Controllers;
  
use XBase\TableReader;
use App\Exports\UsersExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Model\DataMigration\TblItem;
use Maatwebsite\Excel\Facades\Excel; 
use App\Model\DataMigration\TblIgroup;
use App\Model\DataMigration\TblIfvalue;
  
class MyController extends Controller
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function importExportView()
    {  
       return view('import');
    }
   
    /**
    * @return \Illuminate\Support\Collection
    */
    public function export() 
    {
        // return Excel::download(new UsersExport, 'users.xlsx');
    }
   
    /**
    * @return \Illuminate\Support\Collection
    */
    public function import(Request $request) 
    {      
        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        

        if($fileName == "item.dbf"){
            $this->importItemTable($file);
        } 
        
        if($fileName == "ifvalue.dbf"){
            $this->importIfValueTable($file);
        } 
        
        if($fileName == "igroup.dbf"){
            $this->importIgroupTable($file);
        } 
    }

    public function importItemTable($file)
    {
        // $table = new TableReader($file); 
        // while ($record = $table->nextRecord()) {
        //     // if($record->itemid <= 40000){
        //         // if($record->itemid > 40000 && $record->itemid <= 80000){
        //         if($record->itemid > 80000){

        //         $records[] = [
        //             'item_id' => $record->itemid,
        //             'iname' => $record->iname,
        //             'icode' => $record->icode,
        //             'igroupid' => $record->igroupid
        //         ];
        //     } 
        // }  
        // foreach($records as $data){ 
        //     TblItem::insert($data);
        // }
        dd("Succeess"); 
    }

    public function importIfValueTable($file)
    {
        // $table = new TableReader($file); 
        // while ($record = $table->nextRecord()) {
        //     // if($record->itemid <= 40000){
        //         // if($record->itemid > 40000 && $record->itemid <= 80000){
        //         if($record->itemid > 80000){

        //         $records[] = [
        //             'item_id' => $record->itemid,
        //             'length' => $record->field1,
        //             'width' => $record->field2,
        //             'depth' => $record->field3,
        //             'weight' => $record->field4,
        //             'ri' => $record->field5,
        //             'sg' => $record->field6,
        //             'color' => $record->field7,
        //             'shape' => $record->field8,
        //             'clarity' => $record->field9,
        //             'treatment' => $record->field10,
        //             'picture' => $record->field11,
        //             'origin' => $record->field13,
        //             'specie' => $record->field14,
        //             'grade' => $record->field19,
        //         ];
        //     } 
        // }  
        // foreach($records as $data){ 
        //     TblIfvalue::insert($data);
        // }
        dd("Succeess"); 
    }

    public function importIgroupTable($file)
    {
        $table = new TableReader($file); 
        while ($record = $table->nextRecord()) {
            // if($record->itemid <= 40000){
                // if($record->itemid > 40000 && $record->itemid <= 80000){
                // if($record->itemid > 80000){

                $records[] = [
                    'igroupid' => $record->igroupid,
                    'igname' => $record->igname,
                ];
            // } 
        }  
        foreach($records as $data){ 
            TblIgroup::insert($data);
        }
        dd("Succeess"); 
    }

    public function convertProductId()
    {    
        // //Product ID Update (I Group ID)
        //   try{
        //     DB::beginTransaction();

        //     TblItem::where('igroupid',1)->update(['erp_product_id'=> 9]);
        //     TblItem::where('igroupid',3)->update(['erp_product_id'=> 11]);
        //     TblItem::where('igroupid',5)->update(['erp_product_id'=> 1]);
        //     TblItem::where('igroupid',6)->update(['erp_product_id'=> 4]);
        //     TblItem::where('igroupid',7)->update(['erp_product_id'=> 3]);
        //     TblItem::where('igroupid',8)->update(['erp_product_id'=> 7]);
        //     TblItem::where('igroupid',9)->update(['erp_product_id'=> 6]);
        //     TblItem::where('igroupid',10)->update(['erp_product_id'=> 5]);
        //     TblItem::where('igroupid',11)->update(['erp_product_id'=> 2]);
        //     TblItem::where('igroupid',12)->update(['erp_product_id'=> 13]);
        //     TblItem::where('igroupid',13)->update(['erp_product_id'=> 8]);
        //     TblItem::where('igroupid',14)->update(['erp_product_id'=> 12]);
        //     TblItem::where('igroupid',25)->update(['erp_product_id'=> 8]);
        //     TblItem::where('igroupid',50)->update(['erp_product_id'=> 14]);

        //     DB::commit();
        //     dd("success");
        //   }catch(\Exception $e){       

        //     DB::rollback();
        //     dd($e); 
        // } 


        // //Color ID Update (I Group ID)
        // try{
        //     DB::beginTransaction();

        //     TblIfvalue::where('color','-')->update(['color'=> 20]);
        //     TblIfvalue::where('color','620')->update(['color'=> 23]);
        //     TblIfvalue::where('color','Blue')->update(['color'=> 7]);
        //     TblIfvalue::where('color','Bluish Yellow')->update(['color'=> 15]);
        //     TblIfvalue::where('color','Dark Blue')->update(['color'=> 9]);
        //     TblIfvalue::where('color','Dark Brown')->update(['color'=> 27]);
        //     TblIfvalue::where('color','Dark Green')->update(['color'=> 12]);
        //     TblIfvalue::where('color','Dark Reddish Yellow')->update(['color'=> 24]);
        //     TblIfvalue::where('color','Dark Yellow')->update(['color'=> 6]);
        //     TblIfvalue::where('color','Golden')->update(['color'=> 3]);
        //     TblIfvalue::where('color','Green')->update(['color'=> 10]);
        //     TblIfvalue::where('color','Greenish Yellow')->update(['color'=> 37]);
        //     TblIfvalue::where('color','Greyish White')->update(['color'=> 18]);
        //     TblIfvalue::where('color','J')->update(['color'=> 47]);
        //     TblIfvalue::where('color','Light Blue')->update(['color'=> 8]);
        //     TblIfvalue::where('color','Light Green')->update(['color'=> 11]);
        //     TblIfvalue::where('color','Light Greyish White')->update(['color'=> 18]);
        //     TblIfvalue::where('color','Light Pink')->update(['color'=> 2]);
        //     TblIfvalue::where('color','Light Yellow')->update(['color'=> 21]);
        //     TblIfvalue::where('color','Off White')->update(['color'=> 20]);
        //     TblIfvalue::where('color','Peacock Black')->update(['color'=> 4]);
        //     TblIfvalue::where('color','Pink')->update(['color'=> 16]);
        //     TblIfvalue::where('color','Pinkish Blue')->update(['color'=> 25]);
        //     TblIfvalue::where('color','Pomegranate Red')->update(['color'=> 23]);
        //     TblIfvalue::where('color','Purple Blue')->update(['color'=> 36]);
        //     TblIfvalue::where('color','Red')->update(['color'=> 13]);
        //     TblIfvalue::where('color','Reddish Blue')->update(['color'=> 26]);
        //     TblIfvalue::where('color','Reddish Yellow')->update(['color'=> 24]);
        //     TblIfvalue::where('color','White')->update(['color'=> 20]); 
        //     TblIfvalue::where('color','White Transparent')->update(['color'=> 22]);
        //     TblIfvalue::where('color','Yellow')->update(['color'=> 5]);
        //     TblIfvalue::where('color','Yellowish Blue')->update(['color'=> 19]); 

        //     DB::commit();
        //     dd("success");
        // }catch(\Exception $e){       

        //     DB::rollback();
        //     dd($e); 
        // }


        // //Shape ID Update (I Group ID)
        // try{
        //     DB::beginTransaction();
 
        //     TblIfvalue::where('shape','Octagonal')->update(['shape' => 9]);
        //     TblIfvalue::where('shape','Oval')->update(['shape' => 1]);
        //     TblIfvalue::where('shape','Rectangular Cushion')->update(['shape' => 2]);
        //     TblIfvalue::where('shape','Round')->update(['shape' => 6]);
        //     TblIfvalue::where('shape','Rectangular')->update(['shape' => 22]);
        //     TblIfvalue::where('shape','Capsule')->update(['shape' => 7]);
        //     TblIfvalue::where('shape','Triangular')->update(['shape' => 24]);
        //     TblIfvalue::where('shape','Round Beads')->update(['shape' => 25]);
        //     TblIfvalue::where('shape','Square Cushion')->update(['shape' => 3]);
        //     TblIfvalue::where('shape','Pear')->update(['shape' => 10]);
        //     TblIfvalue::where('shape','Rhomboid')->update(['shape' => 26]);
        //     TblIfvalue::where('shape','Square')->update(['shape' => 20]);
        //     TblIfvalue::where('shape','Statue')->update(['shape' => 5]);
        //     TblIfvalue::where('shape','Irregular')->update(['shape' => 23]);
        //     TblIfvalue::where('shape','Oval Cabochon')->update(['shape' => 8]);
        //     TblIfvalue::where('shape','Round Cabochon')->update(['shape' => 8]);
        //     TblIfvalue::where('shape','Round Brilliant')->update(['shape' => 27]); 
             
        //     DB::commit();
        //     dd("success");
        // }catch(\Exception $e){       

        //     DB::rollback();
        //     dd($e); 
        // } 


        // //Clarity ID Update (I Group ID)
        // try{
        //     DB::beginTransaction();
 
        //     TblIfvalue::where('clarity','Translucent')->update(['clarity' => 2]); 
        //     TblIfvalue::where('clarity','Transparent')->update(['clarity' => 1]); 
        //     TblIfvalue::where('clarity','Opaque')->update(['clarity' => 3]); 
        //     TblIfvalue::where('clarity','Translucnet')->update(['clarity' => 2]); 
        //     TblIfvalue::where('clarity','Translucent')->update(['clarity' => 2]); 
        //     TblIfvalue::where('clarity','Oapque')->update(['clarity' => 3]); 
        //     TblIfvalue::where('clarity','Translucent Red')->update(['clarity' => 2]); 
        //     TblIfvalue::where('clarity','Translcuent')->update(['clarity' => 2]); 
        //     TblIfvalue::where('clarity','Translucent`')->update(['clarity' => 2]); 
        //     TblIfvalue::where('clarity','Transparnet')->update(['clarity' => 1]); 
        //     TblIfvalue::where('clarity','Opauqe')->update(['clarity' => 3]); 
        //     TblIfvalue::where('clarity','.Translucent')->update(['clarity' => 2]); 
        //     TblIfvalue::where('clarity','.Opaque')->update(['clarity' => 3]); 
        //     // TblIfvalue::where('clarity','-')->update(['clarity' => 9235423254]); 
        //     TblIfvalue::where('clarity','VS1')->update(['clarity' => 11]);  
             

        //     DB::commit();
        //     dd("success");
        // }catch(\Exception $e){       

        //     DB::rollback();
        //     dd($e); 
        // } 

        //Treatment ID Update (I Group ID)
        try{
            DB::beginTransaction();
 
            TblIfvalue::where('treatment','Color Enhanced')->update(['treatment' => 4]);     
            TblIfvalue::where('treatment','!=','Color Enhanced')->update(['treatment' => 3]);     

 

            DB::commit();
            dd("success");
        }catch(\Exception $e){       

            DB::rollback();
            dd($e); 
        } 


        // //Origin ID Update (I Group ID)
        // try{
        //     DB::beginTransaction();
 
        //     // TblIfvalue::where('origin','')->update(['origin' => 2524354325]);  
        //     // TblIfvalue::where('origin','-')->update(['origin' => 2524354325]);  
        //     TblIfvalue::where('origin','.Brazil')->update(['origin' => 4]);  
        //     TblIfvalue::where('origin','.Italy')->update(['origin' => 8]);  
        //     TblIfvalue::where('origin','.Sri Lanka')->update(['origin' => 2]);  
        //     // TblIfvalue::where('origin','4.02')->update(['origin' => 2524354325]);  
        //     TblIfvalue::where('origin','Africa')->update(['origin' => 17]);  
        //     TblIfvalue::where('origin','Australia')->update(['origin' => 20]);  
        //     TblIfvalue::where('origin','Bangkok')->update(['origin' => 18]);  
        //     TblIfvalue::where('origin','Basra')->update(['origin' => 6]);  
        //     TblIfvalue::where('origin','Brazil')->update(['origin' => 4]);  
        //     TblIfvalue::where('origin','Burma')->update(['origin' => 10]);  
        //     TblIfvalue::where('origin','Columbia')->update(['origin' => 5]);  
        //     // TblIfvalue::where('origin','Cultured')->update(['origin' => 2524354325]);  
        //     // TblIfvalue::where('origin','False')->update(['origin' => 2524354325]);  
        //     TblIfvalue::where('origin','India')->update(['origin' => 1]);  
        //     TblIfvalue::where('origin','Italy')->update(['origin' => 8]);  
        //     TblIfvalue::where('origin','Kashmir')->update(['origin' => 7]);  
        //     TblIfvalue::where('origin','Sri Lanka')->update(['origin' => 2]);  
        //     TblIfvalue::where('origin','Venezuela')->update(['origin' => 3]);  
        //     TblIfvalue::where('origin','Zambia')->update(['origin' => 11]);  
           

        //     DB::commit();
        //     dd("success");
        // }catch(\Exception $e){       

        //     DB::rollback();
        //     dd($e); 
        // } 


        // //Specie ID Update (I Group ID)
        // try{
        //     DB::beginTransaction();
 
        //     // TblIfvalue::where('specie','')->update(['specie' => 2524354325]);   
        //     // TblIfvalue::where('specie','-')->update(['specie' => 2524354325]);   
        //     // TblIfvalue::where('specie','-+')->update(['specie' => 2524354325]);   
        //     TblIfvalue::where('specie','Beryl')->update(['specie' => 2]);   
        //     TblIfvalue::where('specie','Corundum')->update(['specie' => 1]);   
        //     TblIfvalue::where('specie','Chrysoberyl')->update(['specie' => 4]);   
        //     TblIfvalue::where('specie','Garnet')->update(['specie' => 5]);   
        //     TblIfvalue::where('specie','Mollusk')->update(['specie' => 3]);   
        //     TblIfvalue::where('specie','.Beryl')->update(['specie' => 2]);   
        //     // TblIfvalue::where('specie','0')->update(['specie' => 2524354325]);   

        //     DB::commit();
        //     dd("success");
        // }catch(\Exception $e){       

        //     DB::rollback();
        //     dd($e); 
        // } 


        // //Grade ID Update (I Group ID)
        // try{
        //     DB::beginTransaction();
 
        //     // TblIfvalue::where('grade','')->update(['grade' => 2524354325]);    
        //     TblIfvalue::where('grade','N')->update(['grade' => 1]);    
        //     TblIfvalue::where('grade','F')->update(['grade' => 2]);    
        //     TblIfvalue::where('grade','P')->update(['grade' => 3]);    
        //     TblIfvalue::where('grade','SP1')->update(['grade' => 4]);    
        //     TblIfvalue::where('grade','SP2')->update(['grade' => 5]);    
        //     TblIfvalue::where('grade','SP3')->update(['grade' => 6]);    
        //     TblIfvalue::where('grade','SP4')->update(['grade' => 7]);    
        //     TblIfvalue::where('grade','SP5')->update(['grade' => 8]);    
        //     TblIfvalue::where('grade','SP6')->update(['grade' => 9]);    
        //     TblIfvalue::where('grade','SP7')->update(['grade' => 10]);    
        //     TblIfvalue::where('grade','SP8')->update(['grade' => 11]);    
        //     TblIfvalue::where('grade','SP9')->update(['grade' => 12]);    
        //     TblIfvalue::where('grade','SP10')->update(['grade' => 13]);    
        //     TblIfvalue::where('grade','SP11')->update(['grade' => 14]);    

 

        //     DB::commit();
        //     dd("success");
        // }catch(\Exception $e){       

        //     DB::rollback();
        //     dd($e); 
        // } 

        
    }

    
}