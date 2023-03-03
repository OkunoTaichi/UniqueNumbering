<?php

namespace App\Models\Person;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Authority\M_Authority;

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

    public function M_Authority(){
        return $this->belongsTo(M_Authority::class, 'AuthorityCode','AuthorityCode');
    }

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

    // AuthorityCodeとNameを紐づけて表示
    public function AuthorityName($tenantCode,$tenantBranch){
        // $persons = \DB::table('m_person')->where('TenantBranch', $tenantBranch)
        // ->leftJoin('m_authority',function($join){
        //     $join->on('m_person.AuthorityCode', '=', 'm_authority.AuthorityCode')
        //         ->on('m_person.TenantCode', '=', 'm_authority.TenantCode')
        //         ->where('m_person.TenantBranch', '=', 1111);
        //     })
        //     ->orderByRaw('m_person.updated_at DESC')
        //     ->get();
        $persons = M_Person::where('TenantCode', $tenantCode)
            ->where('TenantBranch', $tenantBranch)
            ->orderBy('updated_at', 'desc')
            ->with('M_Authority')
            ->get();
     
        return $persons;
    }
    
    // 一覧からデータ取得
    public function Person($tenantCode,$tenantBranch,$personCode){
        $person = M_Person::where('TenantCode', $tenantCode)
            ->where('TenantBranch', $tenantBranch)
            ->where('PersonCode', $personCode)
            ->first();
        return $person;
    }

    // 編集のAuthorityCodeからnameを絞り込みセレクトボックスに表示する。
    public function AuthoritySelect($tenantCode,$tenantBranch,$person){
        $authoritySelect = M_Authority::where('TenantCode', $tenantCode)
                ->where('TenantBranch', $tenantBranch)
                ->where('AuthorityCode', $person['AuthorityCode'])
                ->select('AuthorityName')
                ->first();
        return $authoritySelect;
    }

    // 権限の存在チェック
    public function PersonDateCheck($tenantCode,$tenantBranch,$personCode){
        $PersonDateCheck = M_Person::where('TenantCode', $tenantCode)
                ->where('TenantBranch', $tenantBranch)
                ->where('PersonCode', $personCode)
                ->first();
        return $PersonDateCheck;
    }

    // 担当者コードを選択せずに「編集・削除・コピー」を選択した時の処理  ***使っていない***
    public function Check($tenantCode,$tenantBranch,$personCode){
        if($personCode === null){
            $persons = M_Person::get();
            \Session::forget('routeFlag');
            \Session::flash('successe_msg' , '担当者コードを選択してください。');
            return redirect()->route('Person.Person_index')->with(compact('persons'));
        }
    }

    // コピーしたデータをセッションに保存
    public function CopySession($request,$person){
        $request->session()->forget('formCopy');
        $request->session()->put('formCopy', [
            'PersonCode' => $person['PersonCode'],
            'PersonName' => $person['PersonName'],
            'AuthorityCode' => $person['AuthorityCode'],
            'Password' => $person['Password'],
            'Hidden' => $person['Hidden'],
            'DisplayOrder' => $person['DisplayOrder'],
        ]);
    }



}
