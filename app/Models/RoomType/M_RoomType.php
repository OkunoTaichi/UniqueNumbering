<?php

namespace App\Models\RoomType;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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


    
}
