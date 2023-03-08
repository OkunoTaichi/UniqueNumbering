<?php

namespace App\Http\Controllers\RoomType;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RoomType\RoomRequest;
use App\Models\RoomType\M_Room;
use App\Models\RoomType\M_Building;
use App\Models\RoomType\M_RoomType;

class RoomController extends Controller
{
    // 一覧表示
    public function Room_index()
    {
        $user = \Auth::user();
        $tenant_code = $user->tenantCode;
        $tenant_branch = $user->tenantBranch;
        // DBのデータ取得
        $rooms = M_Room::where('TenantCode', $tenant_code)
            ->where('TenantBranch', $tenant_branch)
            ->orderBy('Update', 'desc')
            ->get();
       
        return view(
            'Room.Room_index', compact('rooms')
        );
    }

    // 新規作成画面
    public function Room_create(Request $request)
    {
        // 新規作成モード
        \Session::put(['route_flag' => 0]);
        $route_flag = $request->session()->get('route_flag');

        $user = \Auth::user();
        $tenant_code = $user->tenantCode;
        $tenant_branch = $user->tenantBranch;

        // 棟マスタのセレクトボックス表示　　　　　　部屋タイプマスタは後付け
        $buildings = M_Building::where('TenantCode', $tenant_code)
        ->where('TenantBranch', $tenant_branch)
        ->orderBy('BuildingCode', 'asc')
        ->get();

        return view(
            'Room.Room_create' ,compact('route_flag','buildings')
        );
    }

    // 登録処理
    public function Room_store(RoomRequest $request)
    {
        // 使用するモデル
        $M_Room = new M_Room;

        $user = \Auth::user();
        $tenant_code = $user->tenantCode;
        $tenant_branch = $user->tenantBranch;
        $inputs = $request->all();
        // dd($inputs);
    
        $search_code = $inputs['RoomNo'];
        if(!isset($inputs['Hidden'])){
            $hidden = null;
        }else{
            $hidden = $inputs['Hidden'];
        }
        // ルートフラグ取得
        $route_flag = $request->session()->get('route_flag');
        // データベースにあるかチェック
        $room = $M_Room->RoomDateCheck($tenant_code,$tenant_branch,$search_code);

        if($route_flag == 0 || $route_flag == 3){
            // 新規作成＋コピーの時は存在チェック
            if($room != null){
                \Session::flash('err_msg' , '棟コードが存在しています。');
            }else{
                // 新規作成処理
                $M_Room->CreateRoom($tenant_code,$tenant_branch,$inputs,$hidden);
                \Session::flash('successe_msg' , '登録しました。');
            }
        }elseif($route_flag == 2){
            // 編集モードの時は存在していないとNG
            if($room == null){
                \Session::flash('err_msg' , '棟コードが存在していません。');
            }else{
                // 更新処理
                $M_Room->CreateRoom($tenant_code,$tenant_branch,$inputs,$hidden); 
                \Session::flash('successe_msg' , '更新しました。');
            }
        }
        return redirect( route('Room.Room_create') )->withInput();
    }


    // 詳細画面
    public function Room_detail(Request $request){

        // 使用するモデル
        $M_Room = new M_Room;
        // テナントコードの読み込み
        $user = \Auth::user();
        $tenant_code = $user->tenantCode;
        $tenant_branch = $user->tenantBranch;
        // 検索キー
        $search_code = $request->input('search_code');

        // データベースからデータ取得
        $room = $M_Room->RoomDateCheck($tenant_code,$tenant_branch,$search_code);

        // セレクトボックスの名称表示用
        $building_code = $room['BuildingCode'];
        $building = $M_Room->BuildingDateCheck($tenant_code,$tenant_branch,$building_code);

        // 詳細モード
        \Session::put(['route_flag' => 1]);
        $route_flag = $request->session()->get('route_flag');
 
        return view(
            'Room.Room_create', compact('room','building','route_flag')
        );
    }


    // 編集画面
    public function Room_edit(Request $request){
        // 使用するモデル
        $M_Room = new M_Room;
        // テナントコードの読み込み
        $user = \Auth::user();
        $tenant_code = $user->tenantCode;
        $tenant_branch = $user->tenantBranch;
        // 検索キー
        $search_code = $request->input('edit_search');
        // dd($search_code);

        // データベースからデータ取得
        $room = $M_Room->RoomDateCheck($tenant_code,$tenant_branch,$search_code);

        // セレクトボックスの名称表示用(選択中の表示)
        $building_code = $room['BuildingCode'];
        $building = $M_Room->BuildingDateCheck($tenant_code,$tenant_branch,$building_code);

        // 棟マスタのセレクトボックス表示　　　　　　部屋タイプマスタは後付け
        $buildings = M_Building::where('TenantCode', $tenant_code)
        ->where('TenantBranch', $tenant_branch)
        ->orderBy('BuildingCode', 'asc')
        ->get();

        // 編集モード
        \Session::put(['route_flag' => 2]);
        $route_flag = 2;
 
        return view(
            'Room.Room_create', compact('room','building','buildings','route_flag')
        ); 
    }


    // 削除
    public function Room_destroy(Request $request)
    {
        // 使用するモデル
        $M_Room = new M_Room;
        // テナントコードの読み込み
        $user = \Auth::user();
        $tenant_code = $user->tenantCode;
        $tenant_branch = $user->tenantBranch;
        // 検索キー
        $search_code = $request->input('delete_search');

        // データの存在チェック
        $room = $M_Room->RoomDateCheck($tenant_code,$tenant_branch,$search_code);
        
        if($room !== null)
        {
            $room_code = $room['RoomNo'];
            // 削除ロジック
            $M_Room->RoomDelete($tenant_code,$tenant_branch,$room_code);
            return redirect()->route('Room.Room_index');
        }else{
            \Session::flash('err_msg' , '棟コードが存在していません。');
            return redirect( route('Room.Room_create') )->withInput();
        }
    }



    // コピー 
    public function Room_copy(Request $request){

        // 使用するモデル
        $M_Room = new M_Room;
        // テナントコードの読み込み
        $user = \Auth::user();
        $tenant_code = $user->tenantCode;
        $tenant_branch = $user->tenantBranch;
        // 検索キー
        $search_code = $request->input('copy_search');
        // データの存在チェック
        $room = $M_Room->RoomDateCheck($tenant_code,$tenant_branch,$search_code);

        // セレクトボックスの名称表示用(選択中の表示)
        $building_code = $room['BuildingCode'];
        $building = $M_Room->BuildingDateCheck($tenant_code,$tenant_branch,$building_code);

       
        // 詳細モード
        \Session::put(['route_flag' => 1]);
        $route_flag = $request->session()->get('route_flag');

        if($room !== null)
        { 
            // コピーデータをセッションに保存
            $M_Room->CopySession($request,$room,$building);
            \Session::flash('successe_msg' , 'コピーしました。');
            return view(
                'Room.Room_create', compact('room','building','route_flag')
            );
        }else{
            \Session::flash('err_msg' , 'データが存在していません。');
            return redirect( route('Room.Room_create') )->withInput();
        }
        
    }

    public function Room_paste(Request $request){

        // 使用するモデル
        $M_Building = new M_Building;
        // テナントコードの読み込み
        $user = \Auth::user();
        $tenant_code = $user->tenantCode;
        $tenant_branch = $user->tenantBranch;

        // コピーモード
        \Session::put(['route_flag' => 3]);// DB更新時の振り分け
        $route_flag = $request->session()->get('route_flag');// view表示の振り分け
        $room = $request->session()->get('form_copy');// セッションデータを取得

        // 棟マスタのセレクトボックス表示　　　　　　部屋タイプマスタは後付け
        $buildings = M_Building::where('TenantCode', $tenant_code)
        ->where('TenantBranch', $tenant_branch)
        ->orderBy('BuildingCode', 'asc')
        ->get();

        if($room == null){
            \Session::flash('err_msg' , 'データがありません。コピーしてください。');
            return redirect( route('Room.Room_create') )->withInput();
        }else{
            \Session::flash('successe_msg' , '貼り付けました');
            return view(
                'Room.Room_create', compact('room','buildings','route_flag')
            ); 
        }
    }

}
