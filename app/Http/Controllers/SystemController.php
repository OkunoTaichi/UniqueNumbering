<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SystemRequest;
use App\Models\System;
use App\Models\TNumberInformation;

use DB;

class SystemController extends Controller
{
    public function system_index()
    {
        return view(
            'UnNumber.system_index',
        );
    }

    public function system_create(SystemRequest $request)
    {
        // ➀ 採番区分特定の処理 
        $inputs = $request->all();
     
        // $client は前後の流れが不明なので暫定でこの形
        $client = DB::table('clients')->where('id', $inputs['SignIn'])->orderBy('updated_at', 'desc')->first();

        $edits = TNumberInformation::with(['DivEdits'])
            ->where('tenant_id',$client->tenant_id)// ログインしたユーザーのテナントIDで絞り込む
            ->where('number_id',$inputs['number_id'])// 各種登録ボタンに仕込んでいるナンバーIDを基に採番処理の内容を確定させる。
            ->first();// ナンバーIDは同じテナントID内では被らないものとする

        $dateTime = date('Ymd', strtotime($inputs['date']));
            

        // 使用するモデル
        $System = new System;

        // ➁ 採番するIDの処理 * $change_number 最後DBに更新
        $change_number = $System->numberSearch($edits);
        
        // ➂ 編集区分によって採番するパターンを変更する処理
        $reserve_id = $System->division($edits, $change_number, $dateTime);
        
        // ➃ 予約確定する前にcount_idを更新してしまう。（今回はただの採番の為ユニークキーになるのであればOK）
        // $System->update_id($edits, $change_number);
        // $request->session()->regenerateToken();

        // return view(
        //     'UnNumber.system_confirm', compact('edits', 'client', 'reserve_id')
        // );

        // ➃ 予約確定 バージョン 予約完了画面に移動
        $System->update_create($edits, $reserve_id, $change_number, $client);
        // $request->session()->regenerateToken();

        return view(
            'UnNumber.system_create',  compact('edits', 'client', 'reserve_id')
        );

        
    }
}
