<?php

namespace App\Http\Controllers\RoomType;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RoomType\BuildingRequest;
use App\Models\RoomType\M_Building;

class BuildingController extends Controller
{
    // 一覧表示
    public function Building_index()
    {
        $user = \Auth::user();
        $tenant_code = $user->tenantCode;
        $tenant_branch = $user->tenantBranch;
        // DBのデータ取得
        $buildings = M_Building::where('TenantCode', $tenant_code)
            ->where('TenantBranch', $tenant_branch)
            ->orderBy('Update', 'desc')
            ->get();
       
        return view(
            'Building.Building_index', compact('buildings')
        );
    }

    // 新規作成画面
    public function Building_create(Request $request)
    {
        // 新規作成モード
        \Session::put(['route_flag' => 0]);
        $route_flag = $request->session()->get('route_flag');

        return view(
            'Building.Building_create' ,compact('route_flag')
        );
    }

    // 登録処理
    public function Building_store(BuildingRequest $request)
    {
        // 使用するモデル
        $M_Building = new M_Building;

        $user = \Auth::user();
        $tenant_code = $user->tenantCode;
        $tenant_branch = $user->tenantBranch;
        $inputs = $request->all();
        // dd($inputs);
        $search_code = $inputs['BuildingCode'];
        if(!isset($inputs['Hidden'])){
            $hidden = null;
        }else{
            $hidden = $inputs['Hidden'];
        }
        // ルートフラグ取得
        $route_flag = $request->session()->get('route_flag');
        // データベースにあるかチェック
        $building = $M_Building->BuildingDateCheck($tenant_code,$tenant_branch,$search_code);

        if($route_flag == 0 || $route_flag == 3){
            // 新規作成＋コピーの時は存在チェック
            if($building != null){
                \Session::flash('err_msg' , '棟コードが存在しています。');
            }else{
                // 新規作成処理
                $M_Building->CreateBuilding($tenant_code,$tenant_branch,$inputs,$hidden);
                \Session::flash('successe_msg' , '登録しました。');
            }
        }elseif($route_flag == 2){
            // 編集モードの時は存在していないとNG
            if($building == null){
                \Session::flash('err_msg' , '棟コードが存在していません。');
            }else{
                // 更新処理
                $M_Building->CreateBuilding($tenant_code,$tenant_branch,$inputs,$hidden); 
                \Session::flash('successe_msg' , '更新しました。');
            }
        }
        return redirect( route('Building.Building_create') )->withInput();
    }


    // 詳細画面
    public function Building_detail(Request $request){

        // 使用するモデル
        $M_Building = new M_Building;
        // テナントコードの読み込み
        $user = \Auth::user();
        $tenant_code = $user->tenantCode;
        $tenant_branch = $user->tenantBranch;
        // 検索キー
        $search_code = $request->input('search_code');

        // 一覧からデータ取得
        $building = $M_Building->BuildingDateCheck($tenant_code,$tenant_branch,$search_code);

        // 詳細モード
        \Session::put(['route_flag' => 1]);
        $route_flag = $request->session()->get('route_flag');
 
        return view(
            'Building.Building_create', compact('building','route_flag')
        );
    }

    // 編集画面
    public function Building_edit(Request $request){
        // 使用するモデル
        $M_Building = new M_Building;
        // テナントコードの読み込み
        $user = \Auth::user();
        $tenant_code = $user->tenantCode;
        $tenant_branch = $user->tenantBranch;
        // 検索キー
        $search_code = $request->input('edit_search');
        // dd($search_code);

        // 一覧からデータ取得
        $building = $M_Building->BuildingDateCheck($tenant_code,$tenant_branch,$search_code);

        // 編集モード
        \Session::put(['route_flag' => 2]);
        $route_flag = 2;
 
        return view(
            'Building.Building_create', compact('building','route_flag')
        ); 
    }


    // 削除
    public function Building_destroy(Request $request)
    {
        // 使用するモデル
        $M_Building = new M_Building;
        // テナントコードの読み込み
        $user = \Auth::user();
        $tenant_code = $user->tenantCode;
        $tenant_branch = $user->tenantBranch;
        // 検索キー
        $search_code = $request->input('delete_search');

        // データの存在チェック
        $building = $M_Building->BuildingDateCheck($tenant_code,$tenant_branch,$search_code);
        
        if($building !== null)
        {
            $building_code = $building['BuildingCode'];
            // 削除ロジック
            $M_Building->BuildingDelete($tenant_code,$tenant_branch,$building_code);
            return redirect()->route('Building.Building_index');
        }else{
            \Session::flash('err_msg' , '棟コードが存在していません。');
            return redirect( route('Building.Building_create') )->withInput();
        }
    }



    // コピー 
    public function Building_copy(Request $request){

        // 使用するモデル
        $M_Building = new M_Building;
        // テナントコードの読み込み
        $user = \Auth::user();
        $tenant_code = $user->tenantCode;
        $tenant_branch = $user->tenantBranch;
        // 検索キー
        $search_code = $request->input('copy_search');
        // 存在チェック あればデータ取得
        $building = $M_Building->BuildingDateCheck($tenant_code,$tenant_branch,$search_code);
        // dd($building);
        // 詳細モード
        \Session::put(['route_flag' => 1]);
        $route_flag = $request->session()->get('route_flag');

        if($building !== null)
        { 
            // コピーデータをセッションに保存
            $M_Building->CopySession($request,$building);
            \Session::flash('successe_msg' , 'コピーしました。');
            return view(
                'Building.Building_create', compact('building','route_flag')
            );
        }else{
            \Session::flash('err_msg' , 'データが存在していません。');
            return redirect( route('Building.Building_create') )->withInput();
        }
        
    }




    public function Building_paste(Request $request){

        // 使用するモデル
        $M_Building = new M_Building;
        // テナントコードの読み込み
        $user = \Auth::user();
        $tenant_code = $user->tenantCode;
        $tenant_branch = $user->tenantBranch;

        // コピーモード
        \Session::put(['route_flag' => 3]);// DB更新時の振り分け
        $route_flag = $request->session()->get('route_flag');// view表示の振り分け
        $building = $request->session()->get('form_copy');// セッションデータを取得

        if($building == null){
            \Session::flash('err_msg' , 'データがありません。コピーしてください。');
            return redirect( route('Building.Building_create') )->withInput();
        }else{
            \Session::flash('successe_msg' , '貼り付けました');
            return view(
                'Building.Building_create', compact('building','route_flag')
            ); 
        }
    }




}
