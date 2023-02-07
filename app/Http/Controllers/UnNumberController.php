<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SearchRequest;
use App\Models\M_Numbering;
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
        $searchId_2 = $request->input('searchId_2');
        $query = M_Numbering::query();
      
        $s_tenantbranchs = DB::table('m_tenantbranch')->get();
        $s_tenants = DB::table('m_tenant')->get();

        

        //入力された場合、un_numbersテーブルから完全に一致するIdを$queryに代入
        if (isset($searchId , $searchId_2)) {
            $query->with(['Tenants','TenantBranchs'])
            ->where('TenantCode',self::escapeLike($searchId))
            ->where('TenantBranch',self::escapeLike($searchId_2))
            ->with(['division_numbers' => function($query)
            {
                $query->where('DivCode','NumberDiv');
            }])
            ->with(['division_edits' => function($query)
            {
                $query->where('DivCode','EditDiv');
            }])
            ->with(['division_dates' => function($query)
            {
                $query->where('DivCode','DateDiv');
            }])
            ->get();
           
            $UnNumbers = $query->orderBy('updated_at', 'desc')->paginate(7);//$queryをupdated_atの新しい順に並び替え（最近更新したのが上にくる）
            
            $tenantName = $UnNumbers->first();//会社名と施設名を表示させるために１件だけ取得
            // dd($tenantName);

            return view('UnNumber.UnNumber_index', [
                'UnNumbers' => $UnNumbers,
                'searchId' => $searchId,
                'searchId_2' => $searchId_2,
                'tenantName' => $tenantName,
                's_tenantbranchs' => $s_tenantbranchs,
                's_tenants' => $s_tenants,
            ]);
        }

        // homeから1発目の表示
        return view('UnNumber.UnNumber_index', [
            'searchId' => $searchId,
            's_tenantbranchs' => $s_tenantbranchs,
            's_tenants' => $s_tenants,
        ]);
    }
    
    //「\\」「%」「_」などの記号を文字としてエスケープさせる
    public static function escapeLike($str)
    {
        return str_replace(['\\', '%', '_'], ['\\\\', '\%', '\_'], $str);
    }
   

    public function create()
    {
        // $s_edits = DB::table('EditDiv')->get();
        // $s_dates = DB::table('NumberDiv')->get();

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
        // $t_edit = DB::table('EditDiv')->where('edit_id', $inputs['edit_id'])->first()->edit_name;
        // $t_date = DB::table('NumberDiv')->where('date_id', $inputs['date_id'])->first()->date_name;
        
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
            M_Numbering::create($UnNumberInputs);
            DB::commit();
        
        }catch(\Throwable $e){
            DB::rollback();
            abort(500);
        }
        \Session::flash('err_msg' , '登録しました。');
        return redirect( route('home') );
    }

}
