<?php

namespace App\Models\RoomType;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\M_Division;
use App\Models\Tenant;
use App\Models\TenantBranch;

class M_RoomType extends Model
{
    use HasFactory;

    //テーブル名
    protected $table = 'm_room_type';

    // データ登録処理のための記述する
    use HasCompositePrimaryKeyTrait; // 複合キーの使用許可設定
    protected $primaryKey = ['TenantCode','TenantBranch','RoomTypeCode']; // 複合キーの使用許可設定
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

        'RoomTypeCode',
        'RoomTypeName',
        'RoomTypeAbName',
        'RoomTypeDiv',
        'OperationDiv',
        'RemainingRoomDiv',
        'RealTypeCode',
        'Hidden',
        'DisplayOrder',
        'Update',
        'UpdatePerson',
    ];


    // リレーション

   
    Public function division_room_type_divs()
    {
        return $this->hasMany(M_Division::class, 'DivNo','RoomTypeDiv');
    }
    Public function division_operation_divs()
    {
        return $this->hasMany(M_Division::class, 'DivNo','OperationDiv');
    }
    Public function division_remaining_room_divs()
    {
        return $this->hasMany(M_Division::class, 'DivNo','RemainingRoomDiv');
    }


    Public function Real()
    {
        // 対象のモデル,対象のキー,自分のキー
        return $this->hasMany(M_RoomType::class, 'RoomTypeCode','RealTypeCode');
    }


    




    // セレクトボックス表示
    public function RoomTypeDivs(){
        $room_type_divs = M_Division::where('DivCode', 'RoomTypeDiv')
            ->select('DivNo', 'DivName')
            ->orderBy('DivNo', 'asc')
            ->get();
        return $room_type_divs;
    }
    public function OperationDivs(){
        $operation_divs = M_Division::where('DivCode', 'OperationDiv')
            ->select('DivNo', 'DivName')
            ->orderBy('DivNo', 'asc')
            ->get();
        return $operation_divs;
    }
    public function RemainingRoomDivs(){
        $remaining_room_divs = M_Division::where('DivCode', 'RemainingRoomDiv')
            ->select('DivNo', 'DivName')
            ->orderBy('DivNo', 'asc')
            ->get();
        return $remaining_room_divs;
    }
    public function RealTypeCodes($tenant_code,$tenant_branch){
        $real_type_codes = M_RoomType::where('TenantCode', $tenant_code)
            ->where('TenantBranch', $tenant_branch)
            ->select('RoomTypeCode', 'RoomTypeName')
            ->orderBy('RoomTypeCode', 'asc')
            ->get();
        return $real_type_codes;
    }

    // セレクトボックスの名称表示用（選択中のデータ表示）
    public function RoomTypeDivSelect($room_type_div_code){
        $room_type_div_select = M_Division::where('DivCode', 'RoomTypeDiv')
            ->where('DivNo', $room_type_div_code)
            ->select('DivNo', 'DivName')
            ->first();
        return $room_type_div_select;
    }
    public function OperationDivSelect($operation_div_code){
        $operation_div_select = M_Division::where('DivCode', 'OperationDiv')
            ->where('DivNo', $operation_div_code)
            ->select('DivNo', 'DivName')
            ->first();
        return $operation_div_select;
    }
    public function RemainingRoomDivSelect($remaining_room_div_code){
        $remaining_room_div_select = M_Division::where('DivCode', 'RemainingRoomDiv')
            ->where('DivNo', $remaining_room_div_code)
            ->select('DivNo', 'DivName')
            ->first();
        return $remaining_room_div_select;
    }
    public function RealTypeCodeSelect($tenant_code,$tenant_branch,$real_type_code){
        $real_type_select = M_RoomType::where('TenantCode', $tenant_code)
            ->where('TenantBranch', $tenant_branch)
            ->where('RoomTypeCode', $real_type_code)
            ->select('RoomTypeCode', 'RoomTypeName')
            ->first();
        return $real_type_select;
    }

    // 一覧表示用のデータ（各テーブルのリレーション）
    public function DisplayList($tenant_code,$tenant_branch,$query){
        $room_types = $query->where('TenantCode',$tenant_code)
            ->where('TenantBranch',$tenant_branch,)     
            ->with(['division_room_type_divs' => function($query)
            {
                // DivCodeカラムから値が'RoomTypeDiv'のみ抽出
                $query->where('DivCode','RoomTypeDiv')->select('DivNo','DivName');
            }])
            ->with(['division_operation_divs' => function($query)
            {
                $query->where('DivCode','OperationDiv')->select('DivNo','DivName');
            }])
            ->with(['division_remaining_room_divs' => function($query)
            {
                $query->where('DivCode','RemainingRoomDiv')->select('DivNo','DivName');
            }])

            ->with(['Real' => function($query)
            {
                // 自己結合（モデルで定義）
                $query->select('RoomTypeCode','RoomTypeName');
            }])
            ->orderBy('Update', 'desc')
            ->get();
        
        return $room_types;
    }







    // データベースにあるかチェック（部屋タイプマスタ）
    public function RoomTypeDateCheck($tenant_code,$tenant_branch,$search_code){
        $room_type = M_RoomType::where('TenantCode', $tenant_code)
                ->where('TenantBranch', $tenant_branch)
                ->where('RoomTypeCode', $search_code)
                ->first();
        return $room_type;
    }


    // 新規作成・更新のロジック
    public function CreateRoomType($tenant_code,$tenant_branch,$inputs,$hidden){

        M_RoomType::updateOrCreate(
            [
                "TenantCode" => $tenant_code,
                "TenantBranch" => $tenant_branch,
                "RoomTypeCode" => $inputs['RoomTypeCode']
            ],
            [
                "TenantCode" => $tenant_code,
                "TenantBranch" => $tenant_branch,
                "RoomTypeCode" => $inputs['RoomTypeCode'],
                "RoomTypeName" => $inputs['RoomTypeName'],
                "RoomTypeAbName" => $inputs['RoomTypeAbName'],
                "RoomTypeDiv" => $inputs['RoomTypeDiv'],
                "OperationDiv" => $inputs['OperationDiv'],
                "RemainingRoomDiv" => $inputs['RemainingRoomDiv'],
                "RealTypeCode" => $inputs['RealTypeCode'],
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
    public function RoomTypeDelete($tenant_code,$tenant_branch,$room_type_code){
        \DB::beginTransaction();
        try{
            M_RoomType::where('TenantCode', $tenant_code)
            ->where('TenantBranch', $tenant_branch)
            ->where('RoomTypeCode', $room_type_code)
            ->delete();

            \DB::commit();     
        }catch(\Throwable $e){
            \DB::rollback();
            abort(500);
        }
        \Session::flash('successe_msg' , $room_type_code.' を削除しました。');
    }

    // コピーしたデータをセッションに保存（リアルタイプあるVer）
    public function CopySessionReal($request,$room_type,$room_type_div_select,$operation_div_select,$remaining_room_div_select,$real_type_select){
        $request->session()->forget('form_copy');
        $request->session()->put('form_copy', [
            'RoomTypeCode' => $room_type['RoomTypeCode'],
            'RoomTypeName' => $room_type['RoomTypeName'],
            'RoomTypeAbName' => $room_type['RoomTypeAbName'],
            'RoomTypeDiv' => $room_type['RoomTypeDiv'],
            'RoomTypeDivName' => $room_type_div_select['DivName'],
            'OperationDiv' => $room_type['OperationDiv'],
            'OperationDivName' => $operation_div_select['DivName'],
            'RemainingRoomDiv' => $room_type['RemainingRoomDiv'],
            'RemainingRoomDivName' => $remaining_room_div_select['DivName'],
            'RealTypeCode' => $room_type['RealTypeCode'],
            'RealTypeName' => $real_type_select['RoomTypeName'],
            'DisplayOrder' => $room_type['DisplayOrder'],
            'Hidden' => $room_type['Hidden'],
        ]);
    }

    // コピーしたデータをセッションに保存（リアルタイプなしVer）
    public function CopySession($request,$room_type,$room_type_div_select,$operation_div_select,$remaining_room_div_select){
        $request->session()->forget('form_copy');
        $request->session()->put('form_copy', [
            'RoomTypeCode' => $room_type['RoomTypeCode'],
            'RoomTypeName' => $room_type['RoomTypeName'],
            'RoomTypeAbName' => $room_type['RoomTypeAbName'],
            'RoomTypeDiv' => $room_type['RoomTypeDiv'],
            'RoomTypeDivName' => $room_type_div_select['DivName'],
            'OperationDiv' => $room_type['OperationDiv'],
            'OperationDivName' => $operation_div_select['DivName'],
            'RemainingRoomDiv' => $room_type['RemainingRoomDiv'],
            'RemainingRoomDivName' => $remaining_room_div_select['DivName'],
            'DisplayOrder' => $room_type['DisplayOrder'],
            'Hidden' => $room_type['Hidden'],
        ]);
    }

    
}
