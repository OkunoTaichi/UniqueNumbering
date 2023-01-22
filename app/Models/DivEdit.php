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
        'un_number_id',
        'name',
        'edit_code',
        'memo',
        'updated_at',
    ];

    public function UnNumbers(){
        return $this->belongsTo(UnNumber::class);
    }
}
