<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Tenant extends Model
{
    use HasFactory;

    //テーブル名
    protected $table = 'm_tenant';

    //可変項目
    protected $fillable = 
    [
        'TenantCode',
        'CompanyName',
    ];

    public function M_Numberings(){
        return $this->belongsTo(M_Numbering::class, 'TenantCode','TenantCode');
    }

    
}
