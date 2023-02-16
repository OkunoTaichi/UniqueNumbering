<?php

namespace App\Models\Authority;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_Authority extends Model
{
    use HasFactory;

    //テーブル名
    protected $table = 'm_authority';

    // upDateCreateのための記述する
    use HasCompositePrimaryKeyTrait; // 複合キーの使用許可設定
    protected $primaryKey = ['TenantBranch','AuthorityCode','TenantBranch']; // 複合キーの使用許可設定
    public $incrementing = false; // 複合キーの使用許可設定

    //可変項目
    protected $fillable = 
    [
        'TenantCode',
        'TenantBranch',
        'AuthorityCode',
        'AuthorityName',
        'AdminFlg',
        'UpdatePerson',
    ];
}
