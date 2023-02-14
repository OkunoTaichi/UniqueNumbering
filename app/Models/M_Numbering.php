<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class M_Numbering extends Model    // 一覧検索のみ
{
    use HasFactory;

    //テーブル名
    protected $table = 'M_Numbering';

    //可変項目
    protected $fillable = 
    [
        'TenantCode',
        'TenantBranch',
        'numberdiv',
        'initNumber',
        'symbol',
        'lengs',
        'editdiv',
        'datediv',
        'numbercleardiv',
    ];

    // リレーション関係
    // Public function DivEdits()
    // {
    //     return $this->hasOne(DivEdit::class, 'edit_id','editdiv');
    // }
    // Public function DivDates()
    // {
    //     // DivDateの'date_id'とこの't_number_information'の'datediv'を連結
    //     return $this->hasOne(DivDate::class, 'date_id','datediv');
    // }
    // Public function NumberDivs()
    // {
    //     return $this->hasOne(NumberDiv::class, 'number_id','numberdiv');
    // }
    



    // 全てが詰まったテーブル とりあえずゴールが数値なのでこの形
    Public function division_numbers()
    {
        return $this->hasMany(M_Division::class, 'DivNo','numberdiv');
    }
    Public function division_edits()
    {
        return $this->hasMany(M_Division::class, 'DivNo','editdiv');
    }
    Public function division_dates()
    {
        return $this->hasMany(M_Division::class, 'DivNo','datediv');
    }
    Public function division_numberclears()
    {
        return $this->hasMany(M_Division::class, 'DivNo','numbercleardiv');
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


