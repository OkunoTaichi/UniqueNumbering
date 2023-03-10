<?php

namespace App\Http\Requests\Person;

use Illuminate\Foundation\Http\FormRequest;

class PersonRequest extends FormRequest
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
    protected $redirect = '/Person/Person_create';
    public function rules()
    {
        return [
            'PersonCode' => 'required | max:10 | regex:/^[a-zA-Z0-9 -@\[-~]+$/ ',
            'PersonName' => 'required | max:20',
            'AuthorityCode' => 'required | numeric | max:10000000000',
            'Password' => 'required | min:4| max:20 | regex:/^[a-zA-Z0-9 -@\[-~]+$/ ',
            'Hidden' => 'max:1 | numeric',
            'DisplayOrder' => 'required | numeric | max:10000000000',
        ];
    }
}
