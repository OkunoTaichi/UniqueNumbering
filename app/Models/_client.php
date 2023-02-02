<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    //テーブル名
    protected $table = 'clients';

    //可変項目
    protected $fillable = 
    [
        'name',
        'client_id',
        'tenant_code',
        'registed_at',
        'reserved_at',
        'checked_at',
    ];
}




