<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UnNumber;

class DivEdit extends Model
{
    use HasFactory;

    //テーブル名
    protected $table = 'EditDiv';

    //可変項目
    protected $fillable = 
    [
        'edit_id',
        'edit_name',
        'edit_length',
        'memo',
        'updated_at',
    ];

    public function M_Numberings(){
        return $this->belongsTo(M_Numbering::class, 'edit_id','edit_id');
    }
    

}
