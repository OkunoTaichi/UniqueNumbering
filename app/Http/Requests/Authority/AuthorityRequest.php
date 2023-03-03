<?php

namespace App\Http\Requests\Authority;

use Illuminate\Foundation\Http\FormRequest;

class AuthorityRequest extends FormRequest
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
    protected $redirect =  '/Authority/Authority_index' ;// 確認画面でバリデートNGの場合（意地悪チェック）通常のリダイレクトだとlaravelでルートエラーが起こるので入力画面に戻す
    public function rules()
    {
        return [
            // テナントコードやAuthorityDetailテーブルはコントローラーでバリデーション
            'AuthorityCode' => 'required | numeric | max:10000000000',
            // Authorityテーブル
            'AuthorityName' => 'required | max:10000000000',
            'AdminFlg' => 'max:1',
            'ProgramID' => 'array',
            'ProgramID.*' => 'required',
            'AuthorityDiv' => 'array | required',
            'AuthorityDiv.*' => 'required',
        ];
    }
}
