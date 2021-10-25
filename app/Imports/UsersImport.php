<?php

namespace App\Imports;

use App\Color;
use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToModel
{
     /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {   
        //tbl_color
        // return new Color([
        //     'iname'     => $row[0],
        //     'icolor'    => $row[1],  
        // ]);
        // tbl_grade
        // return new Color([
        //     'grade'     => $row[0],
        //     'grade_name'    => $row[1],  
        //     'grade_abr'    => $row[2],  
        // ]);
        //tbl_origi
        // return new Color([
        //     'iname'     => $row[0],
        //     'icolor'    => $row[1],  
        //     'ocode'    => $row[2],  
        // ]);
        // //tbl_rtprf
        // return new Color([
        //     'pname'     => $row[0],
        //     'id2'    => $row[1],  
        // ]);
        // //tbl_shape
        // return new Color([
        //     'iname'     => $row[0],
        //     'ishape'    => $row[1],  
        // ]);
        // //tbl_speci
        // return new Color([
        //     'iname'     => $row[0],
        //     'icolor'    => $row[1],  
        // ]);
        // //tbl_treat
        // return new Color([
        //     'iname'     => $row[0],
        //     'icolor'    => $row[1],  
        // ]);
        //tbl_item               
        // return new Color([
        //     'item_id' => $row[0],
        //     'iname' => $row[1],  
        //     'icode' => $row[2],  
        //     'igroupid' => $row[3],  
        //     'iunit1' => $row[4],  
        //     'iunit2' => $row[5],  
        //     'iosunit1' => $row[6],  
        //     'iosunit2' => $row[7],  
        //     'iunitcons' => $row[8],  
        //     'iunitconv' => $row[9],  
        //     'iminstock' => $row[10],  
        //     'ipaccount' => $row[11],  
        //     'iprate' => $row[12],  
        //     'isaccount' => $row[13],  
        //     'israte1' => $row[14],  
        //     'israte2' => $row[15],  
        //     'israte3' => $row[16],  
        //     'iosrate' => $row[17],   
        //     'iosvalue' => $row[18],  
        //     'icsunit1' => $row[19],  
        //     'icsunit2' => $row[20],  
        //     'ilistprice' => $row[21],  
        //     'icostprice' => $row[22],  
        //     'selected' => $row[23],  
        //     'grade' => $row[24],  
        //     'rprofile' => $row[25],  
        // ]);
         
       //tbl_ifvalue
        // return new Color([
        //     'item_id' => $row[0],
        //     'length' => $row[1],  
        //     'width' => $row[2],  
        //     'depth' => $row[3],  
        //     'weight' => $row[4],  
        //     'ri' => $row[5],  
        //     'sg' => $row[6],  
        //     'color' => $row[7],  
        //     'shape' => $row[8],  
        //     'clarity' => $row[9],  
        //     'treatment' => $row[10],  
        //     'picture' => $row[11],  
        //     '12' => $row[12],  
        //     'origin' => $row[13],  
        //     'specie' => $row[14],  
        //     '15' => $row[15],  
        //     'label_id' => $row[16],  
        //     'seal_1' => $row[17],   
        //     'seal_2' => $row[18],  
        //     'grade_code' => $row[19],  
        //     'rate_profile' => $row[20]  
        // ]);
 
    }
}
