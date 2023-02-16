<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\M_Numbering;

class NumberDiv extends Model
{
    use HasFactory;

    //テーブル名
    protected $table = 'NumberDiv';

    //可変項目
    protected $fillable = 
    [
        'number_id',
        'number_name',
    ];

    public function M_DateDiv($searchId,$searchId_2){
        
        // リレーションの確認
        // M_Numberingモデルでリレーション設定したdivision_Numbersをつかって'DivCode'と'NumberDiv'が同じものを取ってくる
        $DateDiv = M_Numbering::where('TenantCode', $searchId)
            ->where('TenantBranch', $searchId_2)
            // ->where('numberdiv', 4)
            ->with(['division_Dates' => function ($query)
                {
                    $query->where('DivCode', 'DateDiv');
                }])
            ->get();// この段階でhasMany設定だとリレーション先は複数データがあることになっているので単一での取得は不可
        // dd($DateDiv->division_Dates->DivName);

        return $DateDiv;
    }


   
}
