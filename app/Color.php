<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Color extends  Model
{
     // protected $table ='tbl_color';
     // protected $table ='tbl_grade';
     // protected $table ='tbl_origi';
     // protected $table ='tbl_rtprf';
     // protected $table ='tbl_shape';
     // protected $table ='tbl_speci';
     // protected $table ='tbl_treat'; 
     protected $table ='tbl_item'; 
     // protected $table ='tbl_ifvalue'; 
     protected $guarded =['']; 
}