<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SystemRequest extends FormRequest
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
        return [
            "TenantCode" => 'max:3 ',
            "TenantBranch" => 'numeric | max:4 ',
            "NumberDiv" => 'numeric | max:100 ',
            "DateDiv" => 'numeric | max:100',
            "No" => 'max:1000000000000000 ',
            "CountNumber" => 'numeric | max:1000000000000000',
        ];
    }
}
