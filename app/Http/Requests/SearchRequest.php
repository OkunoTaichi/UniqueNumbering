<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
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
    public function rules()
    {
        // 検索フォームは必須にするとエラーが出ます
        return [
            'searchId' => 'max:100000000 | exists:M_Numbering,TenantCode',
            'searchId_2' => 'max:100000000 | numeric | exists:M_Numbering,TenantBranch',
        ];
    }
}
