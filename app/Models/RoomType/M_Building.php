<?php

namespace App\Models\RoomType;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_Building extends Model
{
    use HasFactory;
    //テーブル名
    protected $table = 'm_building';

    // upDateCreateのための記述する
    use HasCompositePrimaryKeyTrait; // 複合キーの使用許可設定
    protected $primaryKey = ['TenantCode','TenantBranch','BuildingCode']; // 複合キーの使用許可設定
    public $incrementing = false; // 複合キーの使用許可設定

    // timestampの一部のみ使用したい場合は不要の方をnull設定にする必要がある
    const CREATED_AT = null;
    // updateed_atの名前変更
    const UPDATED_AT = 'Update';

    //可変項目
    protected $fillable = 
    [
        'TenantCode',
        'TenantBranch',
        'BuildingCode',
        'BuildingName',
        'BuildingAbName',
        'Hidden',
        'DisplayOrder',
        'Update',
        'UpdatePerson',
    ];

    // データベースにあるかチェック
    public function BuildingDateCheck($tenant_code,$tenant_branch,$search_code){
        $building = M_Building::where('TenantCode', $tenant_code)
                ->where('TenantBranch', $tenant_branch)
                ->where('BuildingCode', $search_code)
                ->first();
        return $building;
    }


    // 新規作成・更新のロジック
    public function CreateBuilding($tenant_code,$tenant_branch,$inputs,$hidden){

        \DB::beginTransaction();
        try{
            M_Building::updateOrCreate(
                [
                    "TenantCode" => $tenant_code,
                    "TenantBranch" => $tenant_branch,
                    "BuildingCode" => $inputs['BuildingCode']
                ],
                [
                    "TenantCode" => $tenant_code,
                    "TenantBranch" => $tenant_branch,
                    "BuildingCode" => $inputs['BuildingCode'],
                    "BuildingName" => $inputs['BuildingName'],
                    "BuildingAbName" => $inputs['BuildingAbName'],
                    "DisplayOrder" => $inputs['DisplayOrder'],
                    "Hidden" => $hidden,
                ] 
            );
            \DB::commit();
        }catch(\Throwable $e){
            \DB::rollback();
            abort(500);
        }
        \Session::flash('successe_msg' , '登録しました。');
    }

    // 削除ロジック
    public function BuildingDelete($tenant_code,$tenant_branch,$building_code){
        \DB::beginTransaction();
        try{
            M_Building::where('TenantCode', $tenant_code)
            ->where('TenantBranch', $tenant_branch)
            ->where('BuildingCode', $building_code)
            ->delete();

            \DB::commit();     
        }catch(\Throwable $e){
            \DB::rollback();
            abort(500);
        }
        \Session::flash('successe_msg' , $building_code.' を削除しました。');
    }


    // コピーしたデータをセッションに保存
    public function CopySession($request,$building){
        $request->session()->forget('form_copy');
        $request->session()->put('form_copy', [
            'BuildingCode' => $building['BuildingCode'],
            'BuildingName' => $building['BuildingName'],
            'BuildingAbName' => $building['BuildingAbName'],
            'DisplayOrder' => $building['DisplayOrder'],
            'Hidden' => $building['Hidden'],
        ]);
    }

  







   
}
