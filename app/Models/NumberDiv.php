<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NumberDiv extends Model
{
    use HasFactory;

    //テーブル名
    protected $table = 'div_numbers';

    //可変項目
    protected $fillable = 
    [
        'number_id',
        'number_name',
    ];

    public function TNumberInformations(){
        return $this->belongsTo(TNumberInformation::class, 'number_id','number_id');
    }
}
