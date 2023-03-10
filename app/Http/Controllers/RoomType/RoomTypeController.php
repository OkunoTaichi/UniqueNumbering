<?php

namespace App\Http\Controllers\RoomType;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RoomType\RoomTypeRequest;
use App\Models\M_Division;
use App\Models\RoomType\M_RoomType;
use DB;

class RoomTypeController extends Controller
{
    // 一覧表示
    public function RoomType_index()
    {
        // 使用するモデル
        $M_RoomType = new M_RoomType;

        $user = \Auth::user();
        $tenant_code = $user->tenantCode;
        $tenant_branch = $user->tenantBranch;

        $query = M_RoomType::query();
        $room_types = $M_RoomType->DisplayList($tenant_code,$tenant_branch,$query);

        return view(
            'RoomType.RoomType_index', compact('room_types')
        );
    }


    // 新規作成画面
    public function RoomType_create(Request $request)
    {
        // 使用するモデル
        $M_RoomType = new M_RoomType;
        // 新規作成モード
        \Session::put(['route_flag' => 0]);
        $route_flag = $request->session()->get('route_flag');

        $user = \Auth::user();
        $tenant_code = $user->tenantCode;
        $tenant_branch = $user->tenantBranch;

        // セレクトボックス表示
        $room_type_divs = $M_RoomType->RoomTypeDivs();
        $operation_divs = $M_RoomType->OperationDivs();
        $remaining_room_divs = $M_RoomType->RemainingRoomDivs();
        $real_type_codes = $M_RoomType->RealTypeCodes($tenant_code,$tenant_branch);

        return view(
            'RoomType.RoomType_create' ,compact('route_flag','real_type_codes','room_type_divs','operation_divs','remaining_room_divs')
        );
    }

    // 登録処理
    public function RoomType_store(RoomTypeRequest $request)
    {
        // 使用するモデル
        $M_RoomType = new M_RoomType;

        $user = \Auth::user();
        $tenant_code = $user->tenantCode;
        $tenant_branch = $user->tenantBranch;
        $inputs = $request->all();
      
        $search_code = $inputs['RoomTypeCode'];

        if(!isset($inputs['Hidden'])){
            $hidden = null;
        }else{
            $hidden = $inputs['Hidden'];
        }
        // ルートフラグ取得
        $route_flag = $request->session()->get('route_flag');
        // データベースにあるかチェック
        $room_type = $M_RoomType->RoomTypeDateCheck($tenant_code,$tenant_branch,$search_code);

        if($route_flag == 0 || $route_flag == 3){
            // 新規作成＋コピーの時は存在チェック
            if($room_type != null){
                \Session::flash('err_msg' , '棟コードが存在しています。');
            }else{
                // 新規作成処理
                $M_RoomType->CreateRoomType($tenant_code,$tenant_branch,$inputs,$hidden);
                \Session::flash('successe_msg' , '登録しました。');
            }
        }elseif($route_flag == 2){
            // 編集モードの時は存在していないとNG
            if($room_type == null){
                \Session::flash('err_msg' , '棟コードが存在していません。');
            }else{
                // 更新処理
                $M_RoomType->CreateRoomType($tenant_code,$tenant_branch,$inputs,$hidden);
                \Session::flash('successe_msg' , '更新しました。');
            }
        }

        return redirect( route('RoomType.RoomType_create') )->withInput();
    }

    // 詳細画面
    public function RoomType_detail(Request $request){

        // 使用するモデル
        $M_RoomType = new M_RoomType;
        // テナントコードの読み込み
        $user = \Auth::user();
        $tenant_code = $user->tenantCode;
        $tenant_branch = $user->tenantBranch;
        // 検索キー
        $search_code = $request->input('search_code');

        // データベースから詳細に出すデータ取得
        $room_type = $M_RoomType->RoomTypeDateCheck($tenant_code,$tenant_branch,$search_code);

        // セレクトボックスの名称表示用（選択中のデータ表示）
        $room_type_div_code = $room_type['RoomTypeDiv'];
        $room_type_div_select = $M_RoomType->RoomTypeDivSelect($room_type_div_code);
        
        $operation_div_code = $room_type['OperationDiv'];
        $operation_div_select = $M_RoomType->OperationDivSelect($operation_div_code);

        $remaining_room_div_code = $room_type['RemainingRoomDiv'];
        $remaining_room_div_select = $M_RoomType->RemainingRoomDivSelect($remaining_room_div_code);
        
        $real_type_code = $room_type['RealTypeCode'];
        $real_type_select = $M_RoomType->RealTypeCodeSelect($tenant_code,$tenant_branch,$real_type_code);
       

        // 詳細モード
        \Session::put(['route_flag' => 1]);
        $route_flag = $request->session()->get('route_flag');
 
        return view(
            'RoomType.RoomType_create', 
            compact(
                'room_type',// 詳細に出すデータ
                'room_type_div_select','operation_div_select','remaining_room_div_select','real_type_select',// 詳細に出すデータ（セレクトボックスの名称）
                'route_flag',
                )
        );
    }

    

    // 削除
    public function RoomType_destroy(Request $request)
    {
        // 使用するモデル
        $M_RoomType = new M_Roomtype;
        // テナントコードの読み込み
        $user = \Auth::user();
        $tenant_code = $user->tenantCode;
        $tenant_branch = $user->tenantBranch;
        // 検索キー
        $search_code = $request->input('delete_search');
        
        // データの存在チェック
        $room_type = $M_RoomType->RoomTypeDateCheck($tenant_code,$tenant_branch,$search_code);
        if($room_type !== null)
        {
            $room_type_code = $room_type['RoomTypeCode'];
            // 削除ロジック
            $M_RoomType->RoomtypeDelete($tenant_code,$tenant_branch,$room_type_code);
            return redirect()->route('RoomType.RoomType_index');
        }else{
            \Session::flash('err_msg' , '棟コードが存在していません。');
            return redirect( route('RoomType.Roomtype_create') )->withInput();
        }
    }

    // 編集画面
    public function RoomType_edit(Request $request){
        // 使用するモデル
        $M_RoomType = new M_RoomType;
        // テナントコードの読み込み
        $user = \Auth::user();
        $tenant_code = $user->tenantCode;
        $tenant_branch = $user->tenantBranch;
        // 検索キー
        $search_code = $request->input('edit_search');

        // セレクトボックス表示データ取得
        $room_type_divs = $M_RoomType->RoomTypeDivs();
        $operation_divs = $M_RoomType->OperationDivs();
        $remaining_room_divs = $M_RoomType->RemainingRoomDivs();
        $real_type_codes = $M_RoomType->RealTypeCodes($tenant_code,$tenant_branch);

        // データベースから詳細に出すデータ取得
        $room_type = $M_RoomType->RoomTypeDateCheck($tenant_code,$tenant_branch,$search_code);

        // セレクトボックスの名称表示用（選択中のデータ表示）
        $room_type_div_code = $room_type['RoomTypeDiv'];
        $room_type_div_select = $M_RoomType->RoomTypeDivSelect($room_type_div_code);
        
        $operation_div_code = $room_type['OperationDiv'];
        $operation_div_select = $M_RoomType->OperationDivSelect($operation_div_code);

        $remaining_room_div_code = $room_type['RemainingRoomDiv'];
        $remaining_room_div_select = $M_RoomType->RemainingRoomDivSelect($remaining_room_div_code);
        
        $real_type_code = $room_type['RealTypeCode'];
        $real_type_select = $M_RoomType->RealTypeCodeSelect($tenant_code,$tenant_branch,$real_type_code);
       

        // 編集モード
        \Session::put(['route_flag' => 2]);
        $route_flag = $request->session()->get('route_flag');
 
        return view(
            'RoomType.RoomType_create', 
            compact(
                'room_type_divs','operation_divs','remaining_room_divs','real_type_codes',// セレクトボックス表示
                'room_type',// 詳細に出すデータ
                'room_type_div_select','operation_div_select','remaining_room_div_select','real_type_select',// 詳細に出すデータ（セレクトボックスの名称）
                'route_flag',
                )
        );
    }


    // コピー 
    public function RoomType_copy(Request $request){

        // 使用するモデル
        $M_RoomType = new M_RoomType;
        // テナントコードの読み込み
        $user = \Auth::user();
        $tenant_code = $user->tenantCode;
        $tenant_branch = $user->tenantBranch;
        // 検索キー
        $search_code = $request->input('copy_search');

        // データベースから詳細に出すデータ取得
        $room_type = $M_RoomType->RoomTypeDateCheck($tenant_code,$tenant_branch,$search_code);

       
        // セレクトボックスの名称表示用（選択中のデータ表示）
        $room_type_div_code = $room_type['RoomTypeDiv'];
        $room_type_div_select = $M_RoomType->RoomTypeDivSelect($room_type_div_code);
        
        $operation_div_code = $room_type['OperationDiv'];
        $operation_div_select = $M_RoomType->OperationDivSelect($operation_div_code);

        $remaining_room_div_code = $room_type['RemainingRoomDiv'];
        $remaining_room_div_select = $M_RoomType->RemainingRoomDivSelect($remaining_room_div_code);
        
        $real_type_code = $room_type['RealTypeCode'];
        //  dd($room_type);
        $real_type_select = $M_RoomType->RealTypeCodeSelect($tenant_code,$tenant_branch,$real_type_code);

       
        // 詳細モード
        \Session::put(['route_flag' => 1]);
        $route_flag = $request->session()->get('route_flag');

        if($room_type !== null)
        { 
            if($real_type_code != null){
                // コピーデータをセッションに保存（リアルタイプあるVer）
                $M_RoomType->CopySessionReal($request,$room_type,$room_type_div_select,$operation_div_select,$remaining_room_div_select,$real_type_select);
            }else{
                // コピーデータをセッションに保存（リアルタイプなしVer）
                $M_RoomType->CopySession($request,$room_type,$room_type_div_select,$operation_div_select,$remaining_room_div_select);
            }

            \Session::flash('successe_msg' , 'コピーしました。');
            return view(
                'RoomType.RoomType_create', 
                compact(
                    'room_type',// 詳細に出すデータ
                    'room_type_div_select','operation_div_select','remaining_room_div_select','real_type_select',// 詳細に出すデータ（セレクトボックスの名称）
                    'route_flag',
                    )
            );
        }else{
            \Session::flash('err_msg' , 'データが存在していません。');
            return redirect( route('RoomType.RoomType_create') )->withInput();
        }
        
    }

    public function RoomType_paste(Request $request){

        // 使用するモデル
        $M_RoomType = new M_RoomType;
        // テナントコードの読み込み
        $user = \Auth::user();
        $tenant_code = $user->tenantCode;
        $tenant_branch = $user->tenantBranch;

        // セレクトボックス表示データ取得
        $room_type_divs = $M_RoomType->RoomTypeDivs();
        $operation_divs = $M_RoomType->OperationDivs();
        $remaining_room_divs = $M_RoomType->RemainingRoomDivs();
        $real_type_codes = $M_RoomType->RealTypeCodes($tenant_code,$tenant_branch);

        // コピーモード
        \Session::put(['route_flag' => 3]);// DB更新時の振り分け
        $route_flag = $request->session()->get('route_flag');// view表示の振り分け
        $room_type = $request->session()->get('form_copy');// セッションデータを取得

        // dd($room_type);

        if($room_type == null){
            \Session::flash('err_msg' , 'データがありません。コピーしてください。');
            return redirect( route('RoomType.RoomType_create') )->withInput();
        }else{
            \Session::flash('successe_msg' , '貼り付けました');
            return view(
                'RoomType.RoomType_create', compact('room_type','room_type_divs','operation_divs','remaining_room_divs','real_type_codes','route_flag')
            ); 
        }
    }






}
