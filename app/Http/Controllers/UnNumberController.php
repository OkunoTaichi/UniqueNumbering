<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UnNumberRequest;
use App\Http\Requests\SearchRequest;
use App\Models\TNumberInformation;
use App\Models\UnNumber;
use App\Models\DivDate;
use App\Models\DivEdit;
use DB;

class UnNumberController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
   
    public function index(SearchRequest $request)
    {
        $searchId = $request->input('searchId');
        $query = TNumberInformation::query();

        

        //入力された場合、un_numbersテーブルから完全に一致するIdを$queryに代入
        if (isset($searchId)) {
            $query->where('tenant_id',self::escapeLike($searchId));
            $UnNumbers = $query->orderBy('created_at', 'desc')->paginate(5);//$queryをupdated_atの新しい順に並び替え（最近更新したのが上にくる）
     
            $tenantName = $UnNumbers->first();//会社名と施設名を表示させるために１件だけ取得

            return view('UnNumber.UnNumber_index', [
                'UnNumbers' => $UnNumbers,
                'searchId' => $searchId,
                'tenantName' => $tenantName,
            ]);
        }
        return view('UnNumber.UnNumber_index', [
            'searchId' => $searchId,
        ]);
    }
    
    //「\\」「%」「_」などの記号を文字としてエスケープさせる
    public static function escapeLike($str)
    {
        return str_replace(['\\', '%', '_'], ['\\\\', '\%', '\_'], $str);
    }
   

    public function create()
    {
        $s_dates = DB::table('div_dates')->get();
        $s_edits = DB::table('div_edits')->get();

        return view(
            'UnNumber.UnNumber_create',compact('s_dates', 's_edits')
        );
    }

    /**
     * 確認する 
     * 
     * @return view
     */
    public function confirm(Request $request)
    {
        $inputs = $request->all();
      
        //入力された値から紐づいている行を取得し、nameカラムを格納する。
        $t_edit = DB::table('div_edits')->where('edit_id', $inputs['edit_id'])->first()->edit_name;
        $t_date = DB::table('div_dates')->where('date_id', $inputs['date_id'])->first()->date_name;
        
        return view(
            'UnNumber.UnNumber_confirm',compact('inputs','t_date', 't_edit', )
        ); 
    }

    public function store(Request $request)
    {
        // データを受け取る
        $UnNumberInputs = $request->all();
        // dd($UnNumberInputs);

        // データを登録
        DB::beginTransaction();
        try{
            TNumberInformation::create($UnNumberInputs);
            DB::commit();
        
        }catch(\Throwable $e){
            DB::rollback();
            abort(500);
        }
        \Session::flash('err_msg' , '登録しました。');
        return redirect( route('home') );
    }

}
