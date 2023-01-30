<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UnNumber;

class DivEdit extends Model
{
    use HasFactory;

    //テーブル名
    protected $table = 'div_edits';

    //可変項目
    protected $fillable = 
    [
        'edit_id',
        'edit_name',
        'edit_length',
        'memo',
        'updated_at',
    ];

    public function TNumberInformations(){
        return $this->belongsTo(TNumberInformation::class, 'edit_id','edit_id');
    }
    
    // public function UnNumbers(){
    //     return $this->belongsTo(UnNumber::class);
    // }
}
