<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected $redirect =  '/UnNumber/edit_create' ;// 確認画面でバリデートNGの場合（意地悪チェック）通常のリダイレクトだとlaravelでルートエラーが起こるので入力画面に戻す
    public function rules()
    {
        return [
            'TenantCode' => 'required | max:100000000 | exists:m_tenant,TenantCode',
            'TenantBranch' => 'required |  max:100000000 | exists:m_tenantbranch,TenantBranch',
            'numberdiv' => 'required | max:100000000 | exists:numberdiv,number_id',
            'initNumber' => 'required | nullable | numeric | max:100000000',
            'symbol' => 'nullable | max:3',
            'editdiv' => 'required |  max:100000000 | exists:editdiv,edit_id',
            'datediv' => 'required | max:100000000 | exists:datediv,date_id',
        ];
    }
}
