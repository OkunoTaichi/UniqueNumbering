<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NumberDiv extends Model
{
    use HasFactory;

    //テーブル名
    protected $table = 'NumberDiv';

    //可変項目
    protected $fillable = 
    [
        'number_id',
        'number_name',
    ];

    public function M_Numberings(){
        return $this->belongsTo(M_Numbering::class, 'number_id','number_id');
    }
}
