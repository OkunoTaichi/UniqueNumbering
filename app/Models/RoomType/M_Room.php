<?php

namespace App\Models\RoomType;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RoomType\M_Building;

class M_Room extends Model
{
    use HasFactory;
    //テーブル名
    protected $table = 'm_room';

    // upDateCreateのための記述する
    use HasCompositePrimaryKeyTrait; // 複合キーの使用許可設定
    protected $primaryKey = ['TenantCode','TenantBranch','RoomNo']; // 複合キーの使用許可設定
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

        'RoomNo',
        'BuildingCode',
        'RoomTypeCode',
        'RoomName',
        'RoomAbName',
        'CapacityMax',
        'CapacityMin',
        'Floor',
        
        'Hidden',
        'DisplayOrder',
        'Update',
        'UpdatePerson',
    ];

    // データベースにあるかチェック（部屋マスタ）
    public function RoomDateCheck($tenant_code,$tenant_branch,$search_code){
        $room = M_Room::where('TenantCode', $tenant_code)
                ->where('TenantBranch', $tenant_branch)
                ->where('RoomNo', $search_code)
                ->first();
        return $room;
    }

    // データベースにあるかチェック（棟マスタ）
    public function BuildingDateCheck($tenant_code,$tenant_branch,$building_code){
        $building = M_Building::where('TenantCode', $tenant_code)
                ->where('TenantBranch', $tenant_branch)
                ->where('BuildingCode', $building_code)
                ->first();
        return $building;
    }

    // 新規作成・更新のロジック
    public function CreateRoom($tenant_code,$tenant_branch,$inputs,$hidden){

        M_Room::updateOrCreate(
            [
                "TenantCode" => $tenant_code,
                "TenantBranch" => $tenant_branch,
                "RoomNo" => $inputs['RoomNo']
            ],
            [
                "TenantCode" => $tenant_code,
                "TenantBranch" => $tenant_branch,
                "BuildingCode" => $inputs['BuildingCode'],
                "RoomTypeCode" => $inputs['RoomTypeCode'],
                "RoomName" => $inputs['RoomName'],
                "RoomAbName" => $inputs['RoomAbName'],
                "CapacityMin" => $inputs['CapacityMin'],
                "CapacityMax" => $inputs['CapacityMax'],
                "Floor" => $inputs['Floor'],
                "DisplayOrder" => $inputs['DisplayOrder'],
                "Hidden" => $hidden,
            ] 
        );
        \DB::beginTransaction();
        try{
            \DB::commit();
        }catch(\Throwable $e){
            \DB::rollback();
            abort(500);
        }
        \Session::flash('successe_msg' , '登録しました。');
    }

    // 削除ロジック
    public function RoomDelete($tenant_code,$tenant_branch,$room_code){
        \DB::beginTransaction();
        try{
            M_Room::where('TenantCode', $tenant_code)
            ->where('TenantBranch', $tenant_branch)
            ->where('RoomNo', $room_code)
            ->delete();

            \DB::commit();     
        }catch(\Throwable $e){
            \DB::rollback();
            abort(500);
        }
        \Session::flash('successe_msg' , $room_code.' を削除しました。');
    }

    // コピーしたデータをセッションに保存
    public function CopySession($request,$room,$building){
        $request->session()->forget('form_copy');
        $request->session()->put('form_copy', [
            'RoomNo' => $room['RoomNo'],
            'BuildingCode' => $room['BuildingCode'],
            'BuildingName' => $building['BuildingName'],
            'RoomTypeCode' => $room['RoomTypeCode'],
            'RoomName' => $room['RoomName'],
            'RoomAbName' => $room['RoomAbName'],
            'CapacityMax' => $room['CapacityMax'],
            'CapacityMin' => $room['CapacityMin'],
            'Floor' => $room['Floor'],
            'DisplayOrder' => $room['DisplayOrder'],
            'Hidden' => $room['Hidden'],
        ]);
    }




}
