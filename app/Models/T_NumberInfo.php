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
        'DateDiv',
        'No',
        'CountNumber',
    ];

    // リレーション関係
    Public function DivEdits()
    {
        return $this->hasOne(DivEdit::class, 'edit_id','editdiv');
    }
    Public function DivDates()
    {
        // DivDateの'date_id'とこの't_number_information'の'datediv'を連結
        return $this->hasOne(DivDate::class, 'date_id','datediv');
    }
    Public function NumberDivs()
    {
        return $this->hasOne(NumberDiv::class, 'number_id','numberdiv');
    }

    Public function Tenants()
    {
        return $this->hasOne(Tenant::class, 'TenantCode','TenantCode');
    }
    Public function TenantBranchs()
    {
        return $this->hasOne(TenantBranch::class, 'TenantBranch','TenantBranch');
    }
}
