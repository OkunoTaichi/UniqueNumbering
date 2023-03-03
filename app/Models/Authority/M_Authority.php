<?php

namespace App\Models\Authority;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Authority\M_Authority;
use App\Models\Authority\M_AuthorityDetail;
use App\Models\Authority\M_Program;
use App\Models\Person\M_Person;
use App\Models\M_Division;

class M_Authority extends Model
{
    use HasFactory;

    //テーブル名
    protected $table = 'm_authority';

    // upDateCreateのための記述する
    use HasCompositePrimaryKeyTrait; // 複合キーの使用許可設定
    protected $primaryKey = ['TenantCode','TenantBranch','AuthorityCode']; // 複合キーの使用許可設定
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

    public function M_Persons(){
        return $this->hasMany(M_Person::class, 'AuthorityCode','AuthorityCode');
    }



    // public function createOnly($tenantCode,$tenantBranch,$authorityInputs){
    //     // クリエイトだけVer
    //         M_Authority::create(
    //         [
    //             "TenantCode" => $tenantCode,
    //             "TenantBranch" => $tenantBranch,
    //             "AuthorityCode" => $authorityInputs['AuthorityCode'],
    //             "AuthorityName" => $authorityInputs['AuthorityName'],
    //             "AdminFlg" => $authorityInputs['AdminFlg'],
    //             // "UpdatePerson" => ,
    //         ]);

    //         // for文でプログラムの数だけクエリを発行する（プログラム数が多くなると負荷がかかる）クリエイトだけVer
    //         for ($i=0; $i<$count; $i++){
    //             $detailInputs = [
    //                 "TenantCode" => $tenantCode,
    //                 "TenantBranch" => $tenantBranch,
    //                 "AuthorityCode" => $authorityInputs['AuthorityCode'],
    //                 "ProgramID" => $authorityInputs['ProgramID'][$i],
    //                 "AuthorityDiv" => $authorityInputs['AuthorityDiv'][$i],
    //             ];
    //             M_AuthorityDetail::create($detailInputs);
    //         }
    //     return ;
    // }


    // 新規作成と更新のロジック
    public function updateCreate($tenantCode,$tenantBranch,$authorityInputs,$count){

        $AuthorityCode = $authorityInputs['AuthorityCode'];
        $AuthorityName = $authorityInputs['AuthorityName'];
        $AdminFlg = $authorityInputs['AdminFlg'];

        // dd($count);
        \DB::beginTransaction();
        try{
            M_Authority::updateOrCreate(
                [
                    "TenantCode" => $tenantCode,
                    "TenantBranch" => $tenantBranch,
                    "AuthorityCode" => $AuthorityCode
                ],
                [
                    "TenantCode" => $tenantCode,
                    "TenantBranch" => $tenantBranch,
                    "AuthorityCode" => $AuthorityCode,
                    "AuthorityName" => $AuthorityName,
                    "AdminFlg" => $AdminFlg,
                    // "UpdatePerson" => ,
                ]);
            
            // updateOrCreateだとプライマーキー関連の処理がかなりめんどくさい（idなど主キーがあればOK。今回はテーブルにないので複合キー作成⇒使用許可にHasCompositePrimaryKeyTrait挟む必要がある。）
            // for文でプログラムの数だけクエリを発行する（プログラム数が多くなると負荷がかかる）
            for ($i=0; $i<$count; $i++){
            
                M_AuthorityDetail::updateOrCreate(
                    [
                        "TenantCode" => $tenantCode,
                        "TenantBranch" => $tenantBranch,
                        "AuthorityCode" => $authorityInputs['AuthorityCode'],
                        "ProgramID" => $authorityInputs['ProgramID'][$i]
                    ],
                    [
                        "TenantCode" => $tenantCode,
                        "TenantBranch" => $tenantBranch,
                        "AuthorityCode" => $authorityInputs['AuthorityCode'],
                        "ProgramID" => $authorityInputs['ProgramID'][$i],
                        "AuthorityDiv" => $authorityInputs['AuthorityDiv'][$i],
                    ]
                );
            }

        \DB::commit();

        }catch(\Throwable $e){
            \DB::rollback();
            abort(500);
        }
    
        \Session::flash('err_msg' , '権限CD '.$AuthorityCode.' を登録しました。');

    }


    // 削除ロジック
    public function authorityDelete($tenantCode,$tenantBranch,$AuthorityCode){
        \DB::beginTransaction();
        try{
            M_Authority::where('TenantCode', $tenantCode)
            ->where('TenantBranch', $tenantBranch)
            ->where('AuthorityCode', $AuthorityCode)
            ->delete();

            M_AuthorityDetail::where('TenantCode', $tenantCode)
            ->where('TenantBranch', $tenantBranch)
            ->where('AuthorityCode', $AuthorityCode)
            ->delete();

            \DB::commit();     
        }catch(\Throwable $e){
            \DB::rollback();
            abort(500);
        }
        \Session::flash('err_msg' , '権限CD '.$AuthorityCode.' を削除しました。');
    }

     // 削除前の権限仕様チェック
     public function PersonCheck($tenantCode,$tenantBranch,$AuthorityCode){
        $PersonCheck = M_Person::where('TenantCode', $tenantCode)
                ->where('TenantBranch', $tenantBranch)
                ->where('AuthorityCode', $AuthorityCode)
                ->first();
        return $PersonCheck;
    }

    // M_Authorityテーブルの存在チェック あればデータ取得
    public function AuthorityCheck($tenantCode,$tenantBranch,$AuthorityCode){
        $AuthorityCheck = M_Authority::where('TenantCode', $tenantCode)
                ->where('TenantBranch', $tenantBranch)
                ->where('AuthorityCode', $AuthorityCode)
                ->first();
        return $AuthorityCheck;
    }

    // DBのデータ取得
    public function AuthorityReload($tenantCode,$tenantBranch){
        $authoritys = M_Authority::where('TenantCode', $tenantCode)
            ->where('TenantBranch', $tenantBranch)
            ->orderBy('AuthorityCode', 'asc')
            ->get();
        return $authoritys;
    }

    // ラジオボタンのデータ取得
    public function RadioOutput(){
        $AuthorityDivs = M_Division::where('DivCode','AuthorityDiv')
            ->select('DivCode','DivNo','DivName')
            ->get();
        return $AuthorityDivs;
    }

    // ラジオボタンのデータ取得
    public function RadioInput($tenantCode,$tenantBranch,$AuthorityCode){
        $AuthorityDetail = M_AuthorityDetail::where('TenantCode', $tenantCode)
            ->where('TenantBranch', $tenantBranch)
            ->where('AuthorityCode', $AuthorityCode)
            ->get();
        return $AuthorityDetail;
    }
    




}
