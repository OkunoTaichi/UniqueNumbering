<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class TenantBranch extends Model
{
    use HasFactory;

    //テーブル名
    protected $table = 'm_tenantbranch';

    //可変項目
    protected $fillable = 
    [
        'TenantCode',
        'TenantBranch',
        'TenantBranchName',
    ];

    public function M_Numberings(){
        return $this->belongsTo(M_Numbering::class, 'TenantBranch','TenantBranch');
    }

    
}
