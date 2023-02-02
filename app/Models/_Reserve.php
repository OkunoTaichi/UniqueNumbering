<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserve extends Model
{
    use HasFactory;

    //テーブル名
    protected $table = 'reserves';

    //可変項目
    protected $fillable = 
    [
        'number_name',
        'reserve_id',
        'client_id',
        'client_name',

        //不要かも
        'change_number',
        'tenant_id',
        'edit_id',
        'edit_name',
        'symbol',
        'edit_length',
        'date_id',
        'date_name',
      
        'updated_at',
    ];
}
