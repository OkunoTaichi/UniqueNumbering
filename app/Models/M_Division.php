<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class M_Division extends Model
{
    use HasFactory;

    //テーブル名
    protected $table = 'm_division';

    //可変項目
    protected $fillable = 
    [
        'DivCode',
        'DivNo',
        'DivName',
        'Value1',
        'Value2',
        'Value3',
        'Value4',
        'Value5',
        'Value6',
        'Value7',
        'Value8',
        'Value9',
        'Value10',
    ];

    public function M_Numberings(){
        return $this->belongsTo(M_Numbering::class, 'numberdiv','DivNo');
    }
    public function M_Edits(){
        return $this->belongsTo(M_Numbering::class, 'editdiv','DivNo');
    }
    public function M_Dates(){
        return $this->belongsTo(M_Numbering::class, 'datediv','DivNo');
    }
    public function M_NumberClears(){
        return $this->belongsTo(M_Numbering::class, 'numbercleardiv','DivNo');
    }

    // public function M_Programs(){
    //     return $this->belongsTo(Authority\M_Program::class, 'Programdiv','DivNo');
    // }

    

   
  
       

      

       

     

    

   
}
