<?php

namespace App\Models\Person;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_Person extends Model
{
    use HasFactory;

    // テーブル名
    protected $table = 'm_person';

    // upDateCreateのための記述する（プライマーキーがあれば不要）
    use HasCompositePrimaryKeyTrait; // 複合キーの使用許可設定
    protected $primaryKey = ['TenantCode','TenantBranch','PersonCode']; // 複合キーの使用許可設定
    public $incrementing = false; // 複合キーの使用許可設定

    // timestampの一部のみ使用したい場合は不要の方をnull設定にする必要がある
    const CREATED_AT = null;

    // 可変項目
    protected $fillable = 
    [
        'TenantCode',
        'TenantBranch',
        'PersonCode',
        'PersonName',
        'AuthorityCode',
        'Password',
        'Hidden',
        'DisplayOrder',
        'Update',
        // 'UpdatePerson',
    ];

    // 新規作成と更新のロジック
    public function updateCreate($tenantCode,$tenantBranch,$personInputs){

        $PersonCode = $personInputs['PersonCode'];
        $PersonName = $personInputs['PersonName'];
        $AuthorityCode = $personInputs['AuthorityCode'];
        $Password = $personInputs['Password'];
        if(isset($personInputs['Hidden'])){
            $Hidden = $personInputs['Hidden'];
        }else{
            $Hidden = null;
        }
        $DisplayOrder = $personInputs['DisplayOrder'];

        \DB::beginTransaction();
        try{
            M_Person::updateOrCreate(
                [
                    "TenantCode" => $tenantCode,
                    "TenantBranch" => $tenantBranch,
                    "PersonCode" => $PersonCode
                ],
                [
                    "TenantCode" => $tenantCode,
                    "TenantBranch" => $tenantBranch,
                    "PersonCode" => $PersonCode,
                    "PersonName" => $PersonName,
                    "AuthorityCode" => $AuthorityCode,
                    "Password" => $Password,
                    "Hidden" => $Hidden,
                    "DisplayOrder" => $DisplayOrder,
                    // "UpdatePerson" => ,
                ]);
            
            
        \DB::commit();

        }catch(\Throwable $e){
            \DB::rollback();
            abort(500);
        }
    
        \Session::flash('successe_msg' , $PersonCode.' を登録しました。');
    }


    // 削除ロジック
    public function PersonDelete($tenantCode,$tenantBranch,$PersonCode){
        \DB::beginTransaction();
        try{
            M_Person::where('TenantCode', $tenantCode)
            ->where('TenantBranch', $tenantBranch)
            ->where('PersonCode', $PersonCode)
            ->delete();

            \DB::commit();     
        }catch(\Throwable $e){
            \DB::rollback();
            abort(500);
        }
        \Session::flash('successe_msg' , $PersonCode.' を削除しました。');
    }



}
