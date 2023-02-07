<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class T_NumberInfo extends Model
{
    use HasFactory;

    //テーブル名
    protected $table = 't_number_info';

    //可変項目
    protected $fillable = 
    [
        'TenantCode',
        'TenantBranch',
        'NumberDiv',
        'NumberDate',
        'No',
        'CountNumber',
    ];

    // リレーション関係

    Public function Tenants()
    {
        return $this->hasOne(Tenant::class, 'TenantCode','TenantCode');
    }
    Public function TenantBranchs()
    {
        return $this->hasOne(TenantBranch::class, 'TenantBranch','TenantBranch');
    }
}
