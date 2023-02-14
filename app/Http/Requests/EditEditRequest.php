<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditEditRequest extends FormRequest
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
    // protected $redirect =  '/UnNumber/edit_edit' ;// 確認画面でバリデートNGの場合（意地悪チェック）通常のリダイレクトだとlaravelでルートエラーが起こるので入力画面に戻す
    public function rules()
    {
        return [
            'TenantCode' => 'required | max:100000000 | exists:m_tenant,TenantCode',
            'TenantBranch' => 'required |  max:100000000 | exists:m_tenantbranch,TenantBranch',
            'numberdiv' => 'required | max:100000000',
            'initNumber' => 'required | numeric | max:1000000000000000',// 15桁まで
            'lengs' => 'required | numeric | max:15',
            'symbol' => 'nullable | max:3 |regex:/^[a-zA-Z]+$/',
            'editdiv' => 'required |  max:100000000 ',
            'datediv' => 'required | max:100000000 ',
        ];
    }
}
